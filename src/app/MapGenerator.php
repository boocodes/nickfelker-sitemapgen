<?php
    /*  SITE PAGES` MAP GENERATOR LIB
     *  MADEN BY NICK FELKER TO PYROBITE
     *  VERSION 1.0
     *
     */

    require_once('exceptions/index.php');


    class MapGenerator{
        private $sitename = "sitename";

        private $file_generation_type = "xml";
        // xml, csv, json. Default - xml
        private $file_path;
        // for ex : /var/www/site.ru/upload/sitemap.xml
        private $if_folder_not_exist_create = true;
        // creating folder to file or not (if not - throw an error)
        private $pages_arr = array();
        // main lib data to gen map
        public function add_page($arr){
            array_push($this->pages_arr, $arr);
        }
        // fill main lib data (an associative array)

        function __construct($sitename = "sitename", $file_generation_type = "xml", $file_path = "./result", $pages_arr = array()){
            print('Map generator constuctor\n');
            $this->sitename = $sitename;
            $this->file_generation_type = $file_generation_type;
            $this->file_path = $file_path;
            $this->pages_arr = $pages_arr;
            if(!empty($pages_arr)){
                $this->create_map();
            }
        }



        // setters
        public function set_file_generation_type($file_generation_type){
            $this->file_generation_type = $file_generation_type;
        }
        public function set_file_path($file_path){
            $this->file_path = $file_path;
        }
        public function set_folder_creating_flag($flag){
            $this->if_folder_not_exist_create = $flag;
        }
        public function set_sitename($sitename){
            $this->sitename = $sitename;
        }
        // getters
        public function get_file_generation_type(){
            return $this->file_generation_type;
        }
        public function get_file_path(){
            return $this->file_path;
        }
        public function get_creating_folder_flag(){
            return $this->if_folder_not_exist_create;
        }
        public function get_sitename(){
            return $this->sitename;
        }
        //
        /*  Main functional lib`s methods
         *  creating files by given arrays
         *
         */

        // checking if code can to create folder and save result
        private function check_access_to_result_folder(){
            if(mkdir($this->file_path . "/test", 0777, true)){
                rmdir($this->file_path . "/test");
                return true;
            }
            else{
                return false;
            }
        }
        // checking if all data are valid

        private function check_valid_data(){
            if(!empty($this->file_generation_type) && !empty($this->file_path) && !empty($this->pages_arr) && !empty($this->sitename)){
                return true;
            }
            else{
                return false;
            }
        }

        private function check_access_to_creating_result_file(){
            if(file_put_contents($this->file_path . '/test.xml', 'test lib')){
                unlink($this->file_path . '/test.xml');
                return true;
            }
            else{
                return false;
            }
        }

        private function complete_lib_validating(){
            if(!$this->check_valid_data()){
                throw new ErrorMapGeneratorDataException();
            }
            elseif(!$this->check_access_to_result_folder()){
                throw new ErrorMapGeneratorDirectoryAccessException();
            }
            elseif(!$this->check_access_to_creating_result_file()){
                throw new ErrorMapGeneratorDataException();
            }
            return true;
        }

        private function create_result_file($result, $extension){
            file_put_contents($this->file_path . "/sitemap." . $extension, $result);
        }

        public function create_map() {
            // validate lib
            if($this->complete_lib_validating()){
                // continue work if all correct
                if($this->file_generation_type == "xml"){
                    $this->generate_xml_map();
                }
                elseif($this->file_generation_type == "json"){
                    $this->generate_json_map();
                }
                elseif($this->file_generation_type == "csv"){
                    $this->generate_csv_map();
                }
                else{
                    throw new ErrorMapGeneratorFileTypeException();
                }
            }
        }

        private function generate_xml_map(){
            $result = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
            foreach($this->pages_arr as $item => $data){
                $result .= "\n<url>";
                if(!empty($data['loc'])){
                    $result .= "\n<loc>" . $data['loc'] . "</loc>";
                }
                if(!empty($data['lastmod'])){
                    $result .= "\n<lastmod>" . $data['lastmod'] . "</lastmod>";
                }
                if(!empty($data['priority'])){
                    $result .= "\n<priority>" . $data['priority'] . "</priority>";
                }
                if(!empty($data['changefreq'])){
                    $result .= "\n<changefreq>" . $data['changefreq'] . "</changefreq>";
                }
                $result .= "\n</url>";
            }
            $result .= "\n</urlset>";
            $this->create_result_file($result, 'xml');
        }


        private function generate_json_map(){
            $result = json_encode($this->pages_arr);
            $this->create_result_file($result, 'json');
        }


        private function generate_csv_map(){
            $result = "loc;lastmod;priority;changefreq\n";
            foreach ($this->pages_arr as $item => $data){
                if(!empty($data['loc'])){
                    $result .= $data['loc'] . ";";
                }
                if(!empty($data['lastmod'])){
                    $result .= $data['lastmod'] . ";";
                }
                if(!empty($data['priority'])){
                    $result .= $data['priority'] . ";";
                }
                if(!empty($data['changefreq'])){
                    $result .= $data['changefreq'] . ";";
                }

                $result .= "\n";
            }
            $this->create_result_file($result, 'csv');
        }



    }