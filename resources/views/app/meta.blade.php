    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{!! asset('asset/img/favicon.png') !!}" type="image/x-icon"/>
@if(isset($meta))
    <title>{{$meta->title}}</title>
    <meta name="description" content="{{$meta->description}}">
    <meta property="og:locale" content="{{$meta->locale}}" />
    <meta property="og:type" content="{{$meta->type}}" />
    <meta property="og:title" content="{{$meta->title}}" />
    <meta property="og:description" content="{{$meta->description}}" />
    <?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") .'://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
    <meta property="og:url" content="<?=$actual_link?>" />
    <meta property="og:image" content="{{$meta->imagePath}}" />
@endif