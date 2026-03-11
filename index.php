<!DOCTYPE html>
<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>War Music Player</title>

<style>

body{
background:#000;
color:#fff;
font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
margin:0;
padding-bottom:180px;
}

header{
padding:16px 24px;
font-size:22px;
font-weight:700;
background:linear-gradient(135deg,#1db954,#1ed760);
color:#000;
box-shadow:0 2px 10px rgba(0,0,0,0.4);
letter-spacing:.02em;
}

.container{
padding:16px 24px 100px;
background:radial-gradient(circle at top left,#272727 0,#121212 45%,#000 100%);
min-height:100vh;
box-sizing:border-box;
max-width:1200px;
margin:0 auto;
}

.loading{
display:flex;
align-items:center;
justify-content:center;
gap:8px;
font-size:14px;
color:#b3b3b3;
margin-top:40px;
}

.loadingDot{
width:6px;
height:6px;
border-radius:50%;
background:#1db954;
animation:bounce 1s infinite ease-in-out;
}

.loadingDot:nth-child(2){animation-delay:.15s;}
.loadingDot:nth-child(3){animation-delay:.3s;}

@keyframes bounce{
0%,80%,100%{transform:scale(0.5);opacity:.4;}
40%{transform:scale(1);opacity:1;}
}

.playlist{
margin-bottom:20px;
background:rgba(24,24,24,0.9);
border-radius:12px;
padding:8px 14px;
box-shadow:0 2px 8px rgba(0,0,0,0.5);
}

.playlistHeader{
color:#fff;
font-size:16px;
cursor:pointer;
padding:6px 2px;
display:flex;
justify-content:space-between;
align-items:center;
font-weight:600;
}

.arrow{
transition:transform .2s;
opacity:.7;
}

.playlist.open .arrow{
transform:rotate(90deg);
opacity:1;
}

.trackList{
max-height:0;
	overflow:hidden;
transition:max-height .3s ease;
}

.playlist.open .trackList{
	max-height:500px;
	overflow-y:auto;
}

.track{
display:flex;
align-items:center;
padding:8px 4px;
border-radius:6px;
cursor:pointer;
transition:background .15s ease,transform .08s ease;
}

.track.active{
background:rgba(29,185,84,0.2);
}

.track:hover{
background:#2a2a2a;
transform:translateY(-1px);
}

.track img{
width:48px;
height:48px;
margin-right:12px;
border-radius:8px;
background:#1e1e1e;
object-fit:cover;
}

.track div div{
font-size:14px;
font-weight:500;
}

.track small{
font-size:12px;
opacity:.7;
}

.player{
position:fixed;
bottom:0;
left:0;
right:0;
background:linear-gradient(180deg,#181818,#000);
padding:10px 16px 14px;
box-shadow:0 -2px 12px rgba(0,0,0,0.9);
display:flex;
flex-direction:column;
gap:6px;
box-sizing:border-box;
border-radius:16px 16px 0 0;
overflow:hidden;
}

.nowPlaying{
display:flex;
align-items:center;
gap:10px;
margin-bottom:4px;
}

.nowPlaying img{
width:48px;
height:48px;
border-radius:10px;
object-fit:cover;
background:#1e1e1e;
}

#now{
font-size:14px;
font-weight:500;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

#titleLine{
font-size:inherit;
font-weight:600;
}

#artistLine{
font-size:13px;
opacity:.8;
margin-top:2px;
}

.progressRow{
display:flex;
flex-direction:column;
gap:4px;
}

.seekWrapper{
position:relative;
width:100%;
height:24px;
}

.seekTrack{
position:absolute;
left:0;
right:0;
top:49%;
transform:translateY(-50%);
height:6px;
border-radius:999px;
background:#333;
overflow:hidden;
}

.seekFill{
height:100%;
width:0%;
background:#1db954;
}

.timeRow{
display:flex;
justify-content:space-between;
font-size:11px;
opacity:.7;
}

.time{
min-width:32px;
text-align:center;
}

#seek{
position:absolute;
left:0;
right:0;
top:62.5%;
transform:translateY(-50%);
width:100%;
height:24px;
border-radius:999px;
background:transparent;
outline:none;
-webkit-appearance:none;
appearance:none;
}

#seek::-webkit-slider-runnable-track{
height:100%;
border-radius:3px;
background:transparent;
}

#seek::-webkit-slider-thumb{
-webkit-appearance:none;
appearance:none;
width:14px;
height:14px;
border-radius:50%;
background:#1db954;
cursor:pointer;
box-shadow:0 0 4px rgba(0,0,0,0.4);
}

#seek::-moz-range-track{
height:6px;
border-radius:3px;
background:#333;
}

#seek::-moz-range-thumb{
width:14px;
height:14px;
border-radius:50%;
background:#1db954;
border:none;
cursor:pointer;
box-shadow:0 0 4px rgba(0,0,0,0.4);
}

.controlsRow{
display:flex;
align-items:center;
justify-content:space-between;
gap:8px;
margin-top:4px;
}

.controls{
display:flex;
justify-content:center;
gap:14px;
}

.controls button{
background:#2a2a2a;
color:white;
border:none;
width:40px;
height:40px;
border-radius:50%;
cursor:pointer;
display:flex;
align-items:center;
justify-content:center;
transition:background .15s ease,transform .05s ease;
}

.controls button svg{
width:20px;
height:20px;
fill:currentColor;
display:block;
margin:auto;
}

.controls button:hover{
background:#3a3a3a;
transform:scale(1.04);
}

.controls button.active{
background:#1db954;
color:black;
}

.volumeWrapper{
display:flex;
align-items:center;
gap:6px;
min-width:120px;
}

.volumeIcon{
opacity:.8;
}

.volumeIcon svg{
width:16px;
height:16px;
fill:currentColor;
}

#volume{
width:100px;
height:4px;
border-radius:999px;
background:#333;
outline:none;
-webkit-appearance:none;
appearance:none;
}

#volume::-webkit-slider-runnable-track{
height:4px;
border-radius:2px;
background:transparent;
}

#volume::-webkit-slider-thumb{
-webkit-appearance:none;
appearance:none;
width:12px;
height:12px;
border-radius:50%;
background:#1db954;
cursor:pointer;
margin-top:-4px;
box-shadow:0 0 4px rgba(0,0,0,0.4);
}

#volume::-moz-range-track{
height:4px;
border-radius:2px;
background:#333;
}

#volume::-moz-range-thumb{
width:12px;
height:12px;
border-radius:50%;
background:#1db954;
border:none;
cursor:pointer;
box-shadow:0 0 4px rgba(0,0,0,0.4);
}

span.tracksCount{
font-size:12px;
opacity:.7;
margin-left:6px;
}

@media (min-width:1200px){
.track img{
width:56px;
height:56px;
}
.track{
padding:10px 6px;
}
.playlistHeader{
font-size:18px;
}
header{
font-size:24px;
}
}

.player.fullscreen{
top:0;
bottom:0;
left:0;
right:0;
padding:40px 32px 32px;
background:radial-gradient(circle at top left,#1f1f1f 0,#000 60%);
align-items:center;
justify-content:space-between;
}

.player.fullscreen .nowPlaying{
flex-direction:column;
align-items:center;
justify-content:center;
margin-top:16px;
margin-bottom:12px;
text-align:center;
}

.player.fullscreen .nowPlaying img{
width:min(50vh,60vw);
height:min(50vh,60vw);
box-shadow:0 24px 60px rgba(0,0,0,0.7);
}

.player.fullscreen #now{
font-size:24px;
font-weight:600;
margin-top:12px;
}

.player.fullscreen .progressRow{
width:310px;
max-width:100%;
margin:16px auto 0;
}

.player.fullscreen .controlsRow{
max-width:720px;
margin:16px auto 8px;
flex-direction:column;
align-items:center;
gap:12px;
}

.player.fullscreen .controls button{
width:48px;
height:48px;
}

.player.fullscreen .controls button svg{
width:22px;
height:22px;
}

.player.fullscreen .volumeWrapper{
position:absolute;
right:24px;
top:58%;
transform:translateY(-50%);
flex-direction:column-reverse;
align-items:center;
gap:8px;
width:auto;
}

.player.fullscreen #volume{
width:110px;
height:10px;
transform:rotate(-90deg);
transform-origin:center;
}

</style>

</head>

<body>

<header>Music Player</header>

<div class="container">
<div id="playlists">
<div id="loading" class="loading">
<span>Loading tracks</span>
<span class="loadingDot"></span>
<span class="loadingDot"></span>
<span class="loadingDot"></span>
</div>
</div>
</div>

<center style="font-size:11px;">Made with 💚 under 🚀</center>

<div class="player">

<div class="nowPlaying" onclick="toggleFullscreenUI()">

<img id="cover" src="placeholder.svg">

<div id="now">
<div id="titleLine">Nothing Playing</div>
<div id="artistLine"></div>
</div>

</div>

<div class="progressRow">
<div class="seekWrapper">
<div class="seekTrack">
<div class="seekFill" id="seekFill"></div>
</div>
<input type="range" id="seek" value="0" min="0" max="100">
</div>
<div class="timeRow">
<span id="currentTime" class="time">0:00</span>
<span id="duration" class="time">0:00</span>
</div>
</div>

<div class="controlsRow">

<div class="controls">

<button id="prevBtn" onclick="prev()">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M6 6v12h2V6H6zm2 6 9 6V6l-9 6z"/>
</svg>
</button>
<button id="playBtn" onclick="toggle()">
<svg id="playIconSvg" viewBox="0 0 24 24" aria-hidden="true">
<path d="M8 5.14v13.72c0 .8.87 1.3 1.55.86l9.03-6.06a1 1 0 0 0 0-1.72L9.55 4.88A1 1 0 0 0 8 5.14z"/>
</svg>
</button>
<button id="nextBtn" onclick="next()">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M16 6v12h2V6h-2zm-2 6L5 18V6l9 6z"/>
</svg>
</button>
<button id="repeatBtn" onclick="repeat()">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M7 7h9v3l4-4-4-4v3H6a3 3 0 0 0-3 3v4h2V8a1 1 0 0 1 1-1zm10 10H8v-3l-4 4 4 4v-3h10a3 3 0 0 0 3-3v-4h-2v4a1 1 0 0 1-1 1z"/>
</svg>
</button>
<button id="shuffleBtn" onclick="shuffle()">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M14.83 7.17 13.41 8.59 15.83 11H13l-2.3-2.3A2.996 2.996 0 0 0 8.59 8H5v2h3.59l2.3 2.3.01.01L13 15h2.83l-2.42 2.41 1.42 1.42L19 15.66 14.83 7.17zM8 13H5v2h3c.66 0 1.3.26 1.77.73L12 18l1.41-1.41L10.9 14.5A4.01 4.01 0 0 0 8 13zm6-4h2.59L15 6.41 16.41 5 21 9.59 19.59 11 18 9.41V12h-4z"/>
</svg>
</button>
<button id="fullscreenBtn" onclick="toggleFullscreenUI()">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M7 7h4V5H5v6h2V7zm10-2h-6v2h4v4h2V5zM7 13H5v6h6v-2H7v-4zm12 0h-2v4h-4v2h6v-6z"/>
</svg>
</button>
</div>

<div class="volumeWrapper">
<span class="volumeIcon">
<svg viewBox="0 0 24 24" aria-hidden="true">
<path d="M5 9v6h4l4 4V5L9 9H5zm11.54-2.54L15.5 7.5A5 5 0 0 1 17 12a5 5 0 0 1-1.5 3.54l1.04 1.04A6.98 6.98 0 0 0 19 12c0-1.93-.78-3.68-2.46-5.54zM14.5 9.5 13 11a2 2 0 0 1 0 2l1.5 1.5A3.98 3.98 0 0 0 16 12c0-1.1-.45-2.1-1.5-2.5z"/>
</svg>
</span>
<input type="range" id="volume" min="0" max="100" value="80">
</div>

</div>

</div>

<audio id="audio"></audio>

<script>

let playlists={}
let queue=[]
let index=0
let repeatMode=false
let shuffleMode=false
let fullscreenMode=false

const audio=document.getElementById("audio")
const seek=document.getElementById("seek")
const seekFill=document.getElementById("seekFill")
const volume=document.getElementById("volume")
const playBtn=document.getElementById("playBtn")
const repeatBtn=document.getElementById("repeatBtn")
const shuffleBtn=document.getElementById("shuffleBtn")
const fullscreenBtn=document.getElementById("fullscreenBtn")
const coverImg=document.getElementById("cover")
const titleEl=document.getElementById("titleLine")
const artistEl=document.getElementById("artistLine")
const currentTimeEl=document.getElementById("currentTime")
const durationEl=document.getElementById("duration")
const isMobile=/Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent) || window.matchMedia("(max-width: 768px)").matches
const controlsRow=document.querySelector(".controlsRow")

updateSeekAppearance(0)
updateVolumeAppearance(volume.value)

function updateSeekAppearance(value){
let v=parseFloat(value)
if(isNaN(v)) v=0
if(v<0) v=0
if(v>100) v=100
if(seekFill){
seekFill.style.width=v+"%"
}
}

function updateVolumeAppearance(value){
	let v=parseFloat(value)
	if(isNaN(v)) v=0
	if(v<0) v=0
	if(v>100) v=100
	if(volume){
		volume.style.background=`linear-gradient(to right,#1db954 0%,#1db954 ${v}%,#333 ${v}%,#333 100%)`
	}
}

function saveState(){

const state={
index:index,
time:audio.currentTime,
repeat:repeatMode,
shuffle:shuffleMode,
volume:isMobile ? 1 : audio.volume,
}

localStorage.setItem("warMusicPlayerState",JSON.stringify(state))

}

function highlightTrack(){

document.querySelectorAll(".track").forEach(t=>t.classList.remove("active"))

const el=document.querySelector(`.track[data-index="${index}"]`)

if(!el) return

el.classList.add("active")

const playlist=queue[index].playlist
playlist.classList.add("open")

el.scrollIntoView({
behavior:"smooth",
block:"center"
})

}

function play(i){

index=i

audio.src=queue[index].file

seek.value=0
updateSeekAppearance(0)

titleEl.innerText=queue[index].title
artistEl.innerText=queue[index].artist

let csrc=queue[index].cover || "placeholder.svg"
if(csrc.charAt(0)==="/"){csrc="."+csrc}
coverImg.src=csrc
coverImg.onerror=function(){
this.onerror=null
this.src="placeholder.svg"
}

if("mediaSession" in navigator){
try{
const track=queue[index]
navigator.mediaSession.metadata=new MediaMetadata({
title:track.title||"",
artist:track.artist||"",
album:(track.playlistName||""),
artwork:[
{src:csrc,sizes:"96x96",type:"image/jpeg"},
{src:csrc,sizes:"192x192",type:"image/jpeg"}
]
})
}catch(e){}
}

audio.play()

highlightTrack()

updatePlayIcon()

saveState()

}

function toggle(){

if(audio.paused){
audio.play()
}else{
audio.pause()
}

updatePlayIcon()

}

function getRandomIndexInCurrentPlaylist(){

const current=queue[index]
if(!current) return index

const currentPlaylist=current.playlist
const indices=[]

queue.forEach((t,i)=>{
if(t.playlist===currentPlaylist){
indices.push(i)
}
})

if(indices.length<=1) return -1

const choices=indices.filter(i=>i!==index)

return choices[Math.floor(Math.random()*choices.length)]

}

function next(){

if(shuffleMode){
const r=getRandomIndexInCurrentPlaylist()
if(r!==-1){
index=r
}else{
index++
if(index>=queue.length){index=0}
}
}else{
index++
if(index>=queue.length){index=0}
}

play(index)

}

function prev(){

if(shuffleMode){
const r=getRandomIndexInCurrentPlaylist()
if(r!==-1){
index=r
}else{
index--
if(index<0){index=queue.length-1}
}
}else{
index--
if(index<0){index=queue.length-1}
}

play(index)

}

function repeat(){

repeatMode=!repeatMode

if(repeatMode){
repeatBtn.classList.add("active")
}else{
repeatBtn.classList.remove("active")
}
saveState()
}


function shuffle(){

shuffleMode=!shuffleMode

if(shuffleMode){
shuffleBtn.classList.add("active")
}else{
shuffleBtn.classList.remove("active")
}
saveState()
}

function toggleFullscreenUI(){

const player=document.querySelector(".player")
fullscreenMode=!fullscreenMode

if(fullscreenMode){
player.classList.add("fullscreen")
fullscreenBtn.classList.add("active")
const vw=document.querySelector(".volumeWrapper")
if(isMobile && vw){
vw.style.display="none"
if(controlsRow){
controlsRow.style.justifyContent="space-between"
}
}
if(!document.fullscreenElement && document.documentElement.requestFullscreen){
document.documentElement.requestFullscreen().catch(()=>{})
}
}else{
player.classList.remove("fullscreen")
fullscreenBtn.classList.remove("active")
const vw=document.querySelector(".volumeWrapper")
if(isMobile && vw){
vw.style.display="none"
if(controlsRow){
controlsRow.style.justifyContent="center"
}
}
if(document.fullscreenElement && document.exitFullscreen){
document.exitFullscreen().catch(()=>{})
}
}

}

function updatePlayIcon(){

if(audio.paused){
playBtn.innerHTML=`<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5.14v13.72c0 .8.87 1.3 1.55.86l9.03-6.06a1 1 0 0 0 0-1.72L9.55 4.88A1 1 0 0 0 8 5.14z"/></svg>`
}else{
playBtn.innerHTML=`<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5h3v14H8V5zm5 0h3v14h-3V5z"/></svg>`
}

}

function formatTime(sec){
if(!isFinite(sec)) return "0:00"
const m=Math.floor(sec/60)
const s=Math.floor(sec%60)
return `${m}:${s.toString().padStart(2,"0")}`
}

audio.addEventListener("timeupdate",()=>{

if(audio.duration){

const percent=(audio.currentTime/audio.duration)*100
seek.value=percent
updateSeekAppearance(percent)

currentTimeEl.innerText=formatTime(audio.currentTime)
durationEl.innerText=formatTime(audio.duration)

saveState()

}

})

seek.addEventListener("input",()=>{
if(!audio.duration) return
let v=parseFloat(seek.value)
if(isNaN(v)) v=0
if(v<0) v=0
if(v>100) v=100
audio.currentTime=(v/100)*audio.duration
updateSeekAppearance(v)
currentTimeEl.innerText=formatTime(audio.currentTime)
saveState()
})

function handleVolumeChange(){
audio.volume=volume.value/100
updateVolumeAppearance(volume.value)
saveState()
}

volume.addEventListener("input",handleVolumeChange)
volume.addEventListener("change",handleVolumeChange)

if(isMobile){
audio.volume=1
volume.value=100
	updateVolumeAppearance(volume.value)
const vw=document.querySelector(".volumeWrapper")
if(vw){
vw.style.display="none"
if(controlsRow){
controlsRow.style.justifyContent="center"
}
}
}

audio.addEventListener("ended",()=>{

if(repeatMode){

audio.currentTime=0
audio.play()

}else{

next()

}

})

audio.addEventListener("play",updatePlayIcon)
audio.addEventListener("pause",updatePlayIcon)

document.addEventListener("keydown",(e)=>{

if(e.code==="Space"){

e.preventDefault()

toggle()

}

})

document.addEventListener("fullscreenchange",()=>{
if(!document.fullscreenElement){
const player=document.querySelector(".player")
fullscreenMode=false
player.classList.remove("fullscreen")
if(fullscreenBtn){
fullscreenBtn.classList.remove("active")
}
}
})

if("mediaSession" in navigator){
try{
navigator.mediaSession.setActionHandler("play",()=>{
if(audio.paused){toggle()}
})
navigator.mediaSession.setActionHandler("pause",()=>{
if(!audio.paused){toggle()}
})
navigator.mediaSession.setActionHandler("previoustrack",()=>{
prev()
})
navigator.mediaSession.setActionHandler("nexttrack",()=>{
next()
})
navigator.mediaSession.setActionHandler("seekbackward",(details)=>{
const step=details.seekOffset || 10
audio.currentTime=Math.max(0,audio.currentTime-step)
})
navigator.mediaSession.setActionHandler("seekforward",(details)=>{
const step=details.seekOffset || 10
if(audio.duration){
audio.currentTime=Math.min(audio.duration,audio.currentTime+step)
}
})
navigator.mediaSession.setActionHandler("seekto",(details)=>{
if(details.fastSeek && "fastSeek" in audio){
audio.fastSeek(details.seekTime)
}else{
audio.currentTime=details.seekTime
}
})
}catch(e){}
}

fetch("tracks.json")
.then(r=>r.json())
.then(data=>{

playlists=data

const container=document.getElementById("playlists")

const loading=document.getElementById("loading")
if(loading){
container.removeChild(loading)
}

let counter=0

for(let p in playlists){

const playlist=document.createElement("div")
playlist.className="playlist"

const header=document.createElement("div")
header.className="playlistHeader"

header.innerHTML=`<div>${p} <span class="tracksCount">${playlists[p].length}</span></div><span class="arrow">▶</span>`

const trackList=document.createElement("div")
trackList.className="trackList"

header.onclick=()=>{
playlist.classList.toggle("open")
}

playlists[p].forEach((t)=>{

queue.push({...t,playlist,playlistName:p})

const row=document.createElement("div")
row.className="track"
row.dataset.index=counter

let rowCover=t.cover || "placeholder.svg"
if(rowCover.charAt(0)==="/"){rowCover="."+rowCover}
row.innerHTML=`
<img src="${rowCover}" onerror="this.onerror=null;this.src='placeholder.svg';">
<div>
<div>${t.title}</div>
<small>${t.artist}</small>
</div>
`

row.onclick=()=>{
play(parseInt(row.dataset.index))
}

trackList.appendChild(row)

counter++

})

playlist.appendChild(header)
playlist.appendChild(trackList)

container.appendChild(playlist)

}

restoreState()

})

function restoreState(){

const saved=localStorage.getItem("warMusicPlayerState")

if(!saved) return

const state=JSON.parse(saved)

if(!queue[state.index]) return

index=state.index
repeatMode=state.repeat
shuffleMode=state.shuffle
if(!isMobile){
if(typeof state.volume==="number"){
audio.volume=state.volume
volume.value=Math.round(state.volume*100)
}else{
audio.volume=1
volume.value=100
}
		updateVolumeAppearance(volume.value)
}else{
audio.volume=1
volume.value=100
		updateVolumeAppearance(volume.value)
}

if(repeatMode){
repeatBtn.classList.add("active")
}
if(shuffleMode){
shuffleBtn.classList.add("active")
}

audio.src=queue[index].file

titleEl.innerText=queue[index].title
artistEl.innerText=queue[index].artist

let csrc=queue[index].cover || "placeholder.svg"
if(csrc.charAt(0)==="/"){csrc="."+csrc}
coverImg.src=csrc
coverImg.onerror=function(){
this.onerror=null
this.src="placeholder.svg"
}

highlightTrack()

setTimeout(()=>{

audio.currentTime=state.time || 0
currentTimeEl.innerText=formatTime(audio.currentTime)
durationEl.innerText=formatTime(audio.duration || audio.duration)

},200)

}

</script>

</body>

</html>