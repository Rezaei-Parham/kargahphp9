<?php
$question = 'این یک پرسش نمونه است';
$msg = 'این یک پاسخ نمونه است';
$en_name = 'hafez';
$fa_name = 'حافظ';
$filepath = './messages.txt';
$thefile = fopen($filepath,'r');
$peoplefile = file_get_contents('./people.json');
$people = json_decode($peoplefile,true);
if(empty($_POST["person"])){
    $en_name = array_rand($people,1);
}
else{
    $en_name = $_POST["person"];
}
if($thefile){
    $messagelist = explode("\n", fread($thefile, filesize($filepath)));
}
if(empty($_POST["question"])){
   $question="";
}else{
$question = $_POST["question"];
}
$msg = 'این یک پاسخ نمونه است';
if(empty($question)){
    $msg= 'سوال خود را بپرس!';
}elseif(str_starts_with(trim($question),'آیا')==FALSE || (str_ends_with(trim($question),'?')==FALSE && str_ends_with(trim($question),'؟')==FALSE)){
    $msg = 'سوال درستی پرسیده نشده';
}else{
    $msg = $messagelist[hexdec(substr(sha1($question.$en_name),0,8))%count($messagelist)];
}

$fa_name = $people[$en_name];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label" style='display: <?php  echo $question=="" ? "none" : "inline" ?>' >پرسش:</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach ($people as $x => $y){
                    if($en_name == $x){
                        echo '<option  value="'.$x.'"selected' .'>'.$y ."</option>";
                    }else{
                        echo '<option value="'.$x .'">'.$y ."</option>";
                    }
                }
                /*
                 * Loop over people data and
                 * enter data inside `option` tag.
                 * E.g., <option value="hafez">حافظ</option>
                 */
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>