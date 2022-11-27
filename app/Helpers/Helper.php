<?php 

namespace App\Helpers;
use App;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Tags;
use App\Models\Authors;

class Helper
{
    public static function checkArticleSlug($slug){
		$exist = Articles::select('articles.id')
                        ->where('articles.published', 1)
						->where('articles.system_name',$slug)
						->where('show_'.App::getLocale(),1)
                        ->where('categories.type','!=' ,'trash')
                        ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')->first();
        if($exist)return $exist->id;
        return false;
    }

    public static function checkTagSlug($slug){
		$exist = Tags::select('id')->where('lang',App::getLocale())->where('title',$slug)->first();
        if($exist)return $exist->id;
        return false;
    }
    
    public static function checkAuthorSlug($slug){
        $exist = Authors::select('id')->where('published', 1)->where('cant_delete', 0)->where('system_name',$slug)->first();
        if($exist)return $exist->id;
        return false;
    }
    

    public static function checkCategorySlug($slug){
		$exist = Categories::select('id','type')->where('published', 1)->where('system_name',$slug)->first();
        if($exist)return array('id'=>$exist->id,'type' => $exist->type);
        return false;
    }




    public function changeDateFormat($date = false, $format = false){

		switch ($format) {
			case 'm/d/y':
				if(!$date)return null;
				$dateArray = explode('/', $date);
				$year = $dateArray[2];
				$month = $dateArray[1];
				$day = $dateArray[0];
				return \Carbon\Carbon::createFromDate($year, $day, $month)->toDateTimeString();
			break;
			case 'foradmin':
				if(!$date)return null;
				$dateArray = explode('-', $date);
				$year = $dateArray[0];
				$month = $dateArray[1];
				$day = $dateArray[2];
				return $month."/".$day."/".$year;
			break;
			case 'timestemp':
				if(!$date)return '';
				$dt = \Carbon\Carbon::parse($date);
				if(!$dt)return '';

				$month = (strlen($dt->month) == 1) ? '0'.$dt->month : $dt->month;
				$year = (strlen($dt->year) == 1) ? '0'.$dt->year : $dt->year;
				$day = (strlen($dt->day) == 1) ? '0'.$dt->day : $dt->day;

				return $month.'/'.$day.'/'.$year;
			break;
			default:
				return null;
			break;
		}

		return null;
	}

	public function getCategories($categoryId = false,$selectedArray = [],$returnMode = 'options',$lang = 'en'){
        $cats = array();
        if($returnMode == 'options' || $returnMode == 'parent'){
            $result= Categories::select('id','system_name','title_'.$lang.' as title','description_'.$lang.' as description','parent_id')
            ->where('type','!=','authors')
            ->orderBy('ordering', 'desc')
            ->get();
            
            $self = false;
            if  (count($result) > 0){
                foreach($result as $cat){
                    if($categoryId == $cat['id']){
                        $self = $cat;
                    }
                    $cats[$cat['parent_id']][$cat['id']] =  $cat;
                }
            }

        }else{
            $result= Categories::select('id','system_name','menu','type','title_'.$lang.' as title','description_'.$lang.' as description','parent_id')
                    ->where('type','!=','trash')
                    ->orderBy('ordering', 'desc')
                    ->get();
            
            // $authorsCat = false;
            if  (count($result) > 0){
                foreach($result as $cat){
                    if($returnMode == 'menu'){
                        if($cat->menu == 0){
                            continue;    
                        }
                        // if($cat->type == 'authors'){
                        //     $authorsCat = $cat;
                        //     continue;
                        // }
                    }
                    $cats[$cat['parent_id']][$cat['id']] =  $cat;      
                }
                // if($authorsCat){
                //     $parent = 12; // Fix Authors place in menu
                //     $cats[$parent][$authorsCat['id']] = $authorsCat;   
                // }
            }
        }
        
        $disabelChiled = false;
        
        if($returnMode == 'options'){
            return $this->build_options_tree($cats,0,'-',$self,$disabelChiled,$selectedArray);
        }

        if($returnMode == 'parent'){
            return $this->build_parent_tree($cats,$self);
        }

        if($returnMode == 'menu'){
            return array($result,$this->build_category_menu($cats,0));
        }

        if($returnMode == 'ids'){
            $string_id = $this->bulid_ids_tree($cats,$categoryId);
            $return = array_map('intval', explode(",", $string_id, $limit = -1));
            array_unshift($return,$categoryId);
            return $return;
        }
        // if($returnMode == 'menu'){
        //     return $this->build_menu($cats,0,'-',$self,$disabelChiled,$selectedArray);
        // }
        
    }


    public function bulid_ids_tree($cats,$categoryId){

        if(!is_array($cats) || !isset($cats[$categoryId])){
            return null;
        }
        $tree = '';
        foreach($cats[$categoryId] as $cat){
            $tree  .= intval($cat['id']).',';
            $tree  .= $this->bulid_ids_tree($cats,$cat['id']); 
        }
       
        return $tree;
    }

    public  function build_options_tree($cats,$parent_id,$hh,$self,$disabelChiled,$selectedArray){
        
        $hh = $hh.'--';
        
        if(!is_array($cats) || !isset($cats[$parent_id])){
             return null;
        }

        $tree = '';

        foreach($cats[$parent_id] as $cat){
            $catId = $cat["id"];
            $catParentId = $cat["parent_id"];
            $catTitle = $cat["title"];
            
            $disabled = false;
            $selected = false;

            // If Set some self category
            if($self){
                $selfId = $self["id"];
                $selfParentId = $self["parent_id"];

                // Self or this or parent of this category, or self chiled 
                if(($catParentId === $selfId) || $catId == $selfId){//$disabelChiled
                    $disabelChiled = true;
                    $disabled = true;
                }

                //if this category is parent of self category
                if($catId == $selfParentId){
                    $selected = true;
                }
            }

            if($selectedArray && in_array($catId,$selectedArray)){
                $selected = true;
            }

            $disabled = $disabled ? 'disabled' : '';
            $selected = $selected ? 'selected="selected"' : '';

            $tree .= '<option '.$disabled.' '.$selected.' value='.$catId.'>'.$hh.$catTitle.'</option>';
            $tree .= $this->build_options_tree($cats,$catId,$hh,$self,$disabelChiled,$selectedArray);
        }
        return $tree;
    }

    public  function build_category_menu($cats,$parent_id){
        
        if(!is_array($cats) || !isset($cats[$parent_id])){
             return null;
        }

        $tree = '';

        foreach($cats[$parent_id] as $cat){
            $catId = $cat["id"];
            $catTitle = $cat["title"];
            

            $lang = App::getLocale() == 'en' ? '' : 'am';
            $url = url($lang.'/category/'.$cat['system_name']);
            
            if($cat['parent_id'] == 0 && isset($cats[$catId])){
                $tree .= '<li class="nav-link menu-bar-top"><a class="nav-link" href="'.$url.'">'.$catTitle.'</a><ul class="sub-menu">';    
            }else{
                $tree .= '<li class="nav-item menu-bar-top"><a class="nav-link" href="'.$url.'">'.$catTitle.'</a></li>';
            }
            $tree .= $this->build_category_menu($cats,$catId);
            if($cat['parent_id'] == 0 && isset($cats[$catId])){
                $tree .= '</ul></li>';
            }
        }
        return $tree;
    }
    
    public  function build_parent_tree($cats,$cat,$return = []){

        if($cat->parent_id == 0){
            $return[] = $cat;
            return $return;
        }else{
            $return[] = $cat;
            foreach($cats as $parentCats){
                foreach($parentCats as $parent){
                    if($parent->id == $cat->parent_id){
                        return $this->build_parent_tree($cats,$parent,$return);
                    }
                }
            }
        }
    }

    public static function checkPermission($roles = []): bool
    {
        $user = Auth::guard('admin')->user();
        return in_array($user->role, $roles);
    }

    // public function get_category_tree($catId){
    //     $category = Categories::where('id', $catId)->first();
    //     $catArray = [$category->id];
       
    //     if($category->parent_id != 0){
    //         $catParent = Categories::where('system_name', end($catArray))->first();
        
        
    //         if($catParent->parent_id != 0){
    //             $catToPush = Categories::where('id', $catParent->parent_id)->first();
                
    //             array_push($catArray , $catToPush->id);
    //             return $this->get_category_tree($catId);
    //         }
    //     }
    //     return $catArray;
    // }

    // public function getEvetnsCategory(){
    //     $cats = DB::table('categories')->select('id','parent_id')->where('published', 1)->get();
    //     $EVENT_CAT_ID = 2;
        
    //     $cats = $this->findSubs($cats,$EVENT_CAT_ID);
    //     // $cats = call_user_func_array('array_merge', $cats);
    //     var_dump($cats);
    //     exit();
    // }

    // private function findSubs($cats,$parent,$catsArray = []){
    //     foreach($cats as $cat){
    //         if($cat->parent_id == $parent){
    //             $catsArray[] = array_merge($catsArray, $this->findSubs($cats,$cat->id,$catsArray));
    //         }
    //     }
    //     return $catsArray;
    // }

    // private function categoryChild($id) {
    //     $cats = DB::table('categories')->select('id')->where('published', 1)->where('parent_id',$id)->get();

    //     $children = array(); 

    //     foreach($cats as $cat){
    //         $asd = $this->categoryChild($cat->id);
    //         foreach($asd as $a){

    //         }
    //         $children[$cat->id] = $asd;    
    //     }
    //     return $children;
    // }   

    // private function sortNestedArray(&$a) {
    //     sort($a);
    //     for ($i = 0; $i < count($a); $i++) {
    //       if (is_array($a[$i])) {
    //         $this->sortNestedArray($a[$i]);
    //       }
    //     }
    //   }


    // private function array_flatten($array) { 
    //     if (!is_array($array)) { 
    //       return FALSE; 
    //     } 
    //     $result = array(); 
    //     foreach ($array as $key => $value) { 
    //       if (is_array($value)) { 
    //           $result = array_merge($result, $this->array_flatten($value)); 
    //       } 
    //       else { 
    //         $result[$key] = $value; 
    //       } 
    //     } 
    //     return $result; 
    //   }
    public static function getPathInfo()
    {
        return app('request')->create(URL::previous())->getPathInfo();
    }
    public static function isNewCarrier(): bool
    {
        return self::getPathInfo() === '/new-carrier';
    }
}