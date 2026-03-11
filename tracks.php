<?php

require_once __DIR__ . "/getid3/getid3.php";

$base = __DIR__ . "/musics";
$outFile = __DIR__ . "/tracks.json";
$result = [];

function parseFileNameSimple($file){
$name = pathinfo($file, PATHINFO_FILENAME);
if(strpos($name," - ") !== false){
list($artist,$title)=explode(" - ",$name,2);
return [$title,$artist];
}
return [$name,"Unknown"];
}

function analyzeWithGetId3Cli($file){
static $getID3 = null;
if($getID3 === null){
$getID3 = new getID3;
$getID3->option_save_attachments = true;
}
$info = @$getID3->analyze($file);
if(class_exists("getid3_lib")){
@getid3_lib::CopyTagsToComments($info);
}
return $info;
}

function getTitleArtistCli($file){
$info = analyzeWithGetId3Cli($file);
if($info && !empty($info["comments"])){
$comments = $info["comments"];
$title = "";
$artist = "";
if(!empty($comments["title"][0])){
$title = $comments["title"][0];
}
if(!empty($comments["artist"][0])){
$artist = $comments["artist"][0];
}elseif(!empty($comments["albumartist"][0])){
$artist = $comments["albumartist"][0];
}
if($title !== "" || $artist !== ""){
$title = $title !== "" ? $title : pathinfo($file,PATHINFO_FILENAME);
$artist = $artist !== "" ? $artist : "Unknown";
return [$title,$artist];
}
}
return parseFileNameSimple($file);
}

function extractEmbeddedCoverCli($file,$dir){
$info = analyzeWithGetId3Cli($file);
if(!$info) return null;
$picture = null;
if(isset($info["comments"]["picture"][0])){
$picture = $info["comments"]["picture"][0];
}elseif(isset($info["id3v2"]["APIC"][0])){
$picture = $info["id3v2"]["APIC"][0];
}
if(!$picture){
return null;
}
$data = isset($picture["data"]) ? $picture["data"] : null;
$mime = isset($picture["image_mime"]) ? $picture["image_mime"] : (isset($picture["mime"]) ? $picture["mime"] : "image/jpeg");
if(!$data){
return null;
}
$ext = ".jpg";
if(stripos($mime,"png") !== false){
$ext = ".png";
}
$baseName = pathinfo($file,PATHINFO_FILENAME);
$out = "$dir/$baseName$ext";
if(!file_exists($out)){
@file_put_contents($out,$data);
}
if(file_exists($out)){
return $out;
}
return null;
}

function findCoverCli($dir,$file){
$baseName = pathinfo($file,PATHINFO_FILENAME);
$embedded = extractEmbeddedCoverCli($file,$dir);
if($embedded){
return $embedded;
}
$candidates = [
"$dir/$baseName.jpg",
"$dir/$baseName.png",
"$dir/cover.jpg",
"$dir/cover.png",
__DIR__ . "/placeholder.svg",
];
foreach($candidates as $c){
if(file_exists($c)){
return $c;
}
}
return __DIR__ . "/placeholder.svg";
}

function scanFolderCli($dir){
$tracks = [];
foreach(glob("$dir/*.mp3") as $file){
list($title,$artist) = getTitleArtistCli($file);
$cover = findCoverCli($dir,$file);
$tracks[] = [
"file"  => str_replace(__DIR__,"",$file),
"title" => $title,
"artist"=> $artist,
"cover" => str_replace(__DIR__,"",$cover),
];
}
return $tracks;
}

if(!is_dir($base)){
fwrite(STDERR,"musics folder not found.\n");
exit(1);
}

foreach(scandir($base) as $f){
if($f=="." || $f=="..") continue;
$path = "$base/$f";
if(is_dir($path)){
$tracks = scanFolderCli($path);
if($tracks){
$result[$f] = $tracks;
}
}
}

$singles = [];
foreach(glob("$base/*.mp3") as $file){
list($title,$artist) = getTitleArtistCli($file);
$cover = findCoverCli($base,$file);
$singles[] = [
"file"  => str_replace(__DIR__,"",$file),
"title" => $title,
"artist"=> $artist,
"cover" => str_replace(__DIR__,"",$cover),
];
}
if($singles){
$result["Singles"] = $singles;
}

file_put_contents($outFile,json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo "Generated tracks.json with ".count($result)." playlist groups\n";

