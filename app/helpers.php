<?php 
function getCurrencyAndRate(){
    // $cur = currency()->getUserCurrency();
        
    // $rates = DB::table('settings')->whereIn('key', ['rso_rate', 'rs_rate'])->get()->keyBy('key');
    // $RSO_rate = $rates['rso_rate']->value;
    // $RS_rate = $rates['rs_rate']->value;
    

    // $defaultCurrency = currency()->config('default');
    // $currentCurrency = currency()->getCurrency();
    // if($defaultCurrency != $currentCurrency['code']){
    //     $RSO_rate = $RSO_rate * $currentCurrency['exchange_rate'];
    //     $RS_rate = $RS_rate * $currentCurrency['exchange_rate'];
    //     $RSO_rate = round($RSO_rate, 2);
    //     $RS_rate = round($RS_rate, 2);
    // }

    // $currentCurrencyCode = $currentCurrency['code'];
    // $currentCurrencySymbol = $currentCurrency['symbol'];

    // view()->share('currentCurrency', $currentCurrencyCode);
    // view()->share('currentCurrencySymbol', $currentCurrencySymbol);
    // view()->share('currentCurrencyName', $currentCurrency['name']);
    // view()->share('RSO_rate', $RSO_rate);
    // view()->share('RS_rate', $RS_rate);
}