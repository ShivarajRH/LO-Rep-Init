<?php 
 class myactions {
     /**
      * GET API Data
      * @param type $url
      * @param type $outtype
      * @param type $post
      * @return type array
      */
    function getApiContent($url,$outtype,$post='') {
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
                $rdata = file_get_contents($url,false,$content);
            }
            else {
                $rdata = file_get_contents($url,false);
            }
            
            if($outtype=='json') {
                return json_decode($rdata,true);
            }
            else {
                return $rdata;
            }
    }
    
    /**
     * Stopping words will be removed from array
     * @param type $q_arr array
     * @return type array
     * @example "Like: name,is,this,"
     */
    function skip_stopwords($q_arr) {
        $r_arr= array();
        foreach ($q_arr as $i=>$query) {
            if($this->chk_stop_word($query)) {
                //skip the word
            }
            else {
                $r_arr[]=$query;
            }
        }
        return $r_arr;
    }
    
    /**
     * Checks stoping words 
     * @param type $query string
     * @return boolean
     */
    function chk_stop_word($query) {
            $stopwords = array("a", "about", "above", "above", "across", "after", "afterwards", "again",
            "against", "all", "almost", "alone", "along", "already",
            "also","although","always","am","among", "amongst", "amoungst", "amount", "an", "and",
            "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around",
            "as", "at", "back","be","became", "because","become","becomes", "becoming", "been",
            "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond",
            "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could",
            "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg",
            "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever",
            "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find",
            "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front",
            "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here",
            "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how",
            "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself",
            "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me",
            "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move",
            "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next",
            "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off",
            "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours",
            "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re",
            "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should",
            "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone",
            "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten",
            "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter",
            "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this",
            "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too",
            "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon",
            "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence",
            "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon",
            "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom",
            "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours",
            "yourself", "yourselves", "the");
            // check these words are in a
            if(in_array($query,$stopwords)) {
                return true;
            }
            else {
                return false;
            }
    }
    
}
?>