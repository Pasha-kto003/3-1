<?php
function calc()
{
    if (isset($_POST['btnCalc'])){
        $message = "Нечего считать ((((";
        $koef = 1;
        if (isset($_POST['a']) && !empty ($_POST['a']))
        {
            $a = $_POST['a'];
        };
        if (isset($_POST['action']) && !empty ($_POST['action']))
        {
            $action = $_POST['action'];
        };
        if (isset($_POST['choose']) && !empty ($_POST['choose']))
        {
            $choose = $_POST['choose'];
        };
        switch ($action)
        {
            case 'Доллары': switch ($choose)
            {
                case 'Рубли': $koef = 72.5; break;
                case 'Грiвнi': $koef = 26.5; break;
                case 'Тенге': $koef = 424; break;
            }; break;
            case 'Рубли': switch ($choose)
            {
                case 'Доллары': $koef = 0.014; break;
                case 'Грiвнi': $koef = 0.37; break;
                case 'Тенге': $koef = 5.86; break;
            }; break;
            case 'Грiвнi': switch ($choose)
            {
                case 'Доллары': $koef = 0.038; break;
                case 'Рубли': $koef = 2.7; break;
                case 'Тенге': $koef = 16; break;
            }; break;
            case 'Тенге': switch ($choose)
            {
                case 'Доллары': $koef = 0.0024; break;
                case 'Рубли': $koef= 0.17; break;
                case 'Грiвнi': $koef = 0.06; break;
            }; break;
            default: $message = "WTF? ";
        }
    }

    $message = $a * $koef;
    $message .= " $choose";
    return $message;
}
function main(){
    if (!isset($_REQUEST['page'])){
        include ('pages/main.php');

    }else{
        $page =$_REQUEST['page'];
        switch ($page){
            case 'calc': include ('pages/calc.php');break;

            case 'authors': include ('pages/authors.php');break;

            case 'enemies': include ('pages/enemies.php');break;

            case 'guns': include ('pages/guns.php');break;

            case  'news': include ('pages/news.php');break;

            case  'news':getArticleList();break;

            default: include ('pages/main.php');
        }
    }
}

function getArticleList(){
    $dir = 'news/';
    $fileslist = scandir($dir);
    $pages = glob($dir . "*.md");
    foreach ($pages as $page){
     $pagename = substr($page,  8);
     $pagename = substr($pagename, 0,  -3);
        echo "<li><a href=\"index.php?page=".$pagename."\">".$pagename."</a></li>";
    }
}
function articleList(){
    $path = 'news/';
    $file_list = getFileList($path);
    foreach ($file_list as $file){
        $page = getContent($path.$file);
        dbg($page);
    }
}
function getFileList($path){
    $file_list = [];
    foreach (glob( $path . '/*.md') as $dir){
        if (is_file($dir)){
        $file_list[] = basename($dir);
        }
    }
    return $file_list;
}

function getContent($path){
    $page = parseFile($path);
    $pageItem['header'] =(array) json_decode($page[0]);
    $pageItem['body'] = $page[1];
    return $pageItem;
}

function dbg($string){
    echo '<pre>';
    print_r($string);
    echo '</pre>';
}

function getFileContent($path){
    return file_get_contents($path);
}

function parseFile($path){
    $content = explode( '==', getFileContent($path) );
    return $content;
}

?>