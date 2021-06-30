<?php
            //データの追加    
            if( isset($_POST['name']) && isset($_POST['comment'])){
                if($_POST['name'] == '' || $_POST['comment'] == ''){
                    echo '<p>未入力です</p>';
                    return;
                }
                writefile();
                
            }
            function writefile() {
                $contents = file('data.txt', FILE_IGNORE_NEW_LINES);

                $id = count($contents) + 1;
                $name = $_POST['name'];
                $comment = $_POST['comment'];
                $date = date("Y-m-d" ,time());

                $row = $id."<>".$name."<>".$comment."<>".$date;

                //ファイルの追記
                $file = fopen('data.txt', 'a');
                fwrite($file, $row."\n");
            }
            
            
        
        ?>