<?php 
 /*class mycurl {
    function getApiContent($url,$post,$outtype) {
            $content ='';
            if($post != '') {
                $post = http_build_query($post);
                $content = array(
                    "http" => array(
                        "method"=>"POST"
                        ,"header"=> "custom-header: if-any\r\n" .
                                    "custom-header-two: custome-value-2\r\n"
                        ,"content" => $post
                    )
                );
                $content = stream_context_create($content);
            }
            
            $rdata = file_get_contents($url,false,$content);
            
            if($outtype=='json') {
                return json_decode($rdata,true);
            }
            else {
                return $rdata;
            }
    }
    
}*/
?>