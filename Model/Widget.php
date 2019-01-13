<?php

namespace Sidorenkoand\ImageChooser\Model;

use \Magento\Widget\Model\Widget as BaseWidget;

class Widget
{
    public function beforeGetWidgetDeclaration(BaseWidget $subject, $type, $params = [], $asIs = true)
    {
        foreach ($params as $param_key => $param){
            if(preg_match('/_image_chooser$/', $param_key) && strpos($param,'/directive/___directive/') !== false ){
                $parts = explode('/', $param);
                $key   = array_search("___directive", $parts);
                if($key !== false) {

                    $url = $parts[$key+1];
                    $url = base64_decode(strtr($url, '-_,', '+/='));

                    $parts = explode('"', $url);
                    $key   = array_search("{{media url=", $parts);
                    $url   = $parts[$key+1];

                    $params[$param_key] = $url;
                }
            }
        }

        return array($type, $params, $asIs);
    }
}
