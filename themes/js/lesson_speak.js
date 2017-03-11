// JavaScript Document

// ham ramdon
function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 20;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}
function setup() {
	   Wami.setup("wami");
}
function stop() {
		Wami.stopRecording();
}
function stopplay() {
		Wami.stopPlaying();
}
function onError(e) {
	alert(e);
}
function onRecordStart() {
   $('.btn_start_record').hide();
   $('.btn_stop_record').show();
}
function onRecordFinish() {
   $('.btn_stop_record').hide();
   //$('.btn_start_record').show();
   $('.btn_start_play').show();
   $('.btn_next').show();
   $('.au').removeClass('au_selected');
   $('.au'+count_rc+'').addClass('au_selected');
   $('.au'+count_rc+'').attr('id',name);
   $('.au'+count_rc+'').show();
}
function onPlayStart() {
   $('.btn_start_play').hide();
   $('.btn_stop_play').show();
}
function onPlayFinish() {
   $('.btn_stop_play').hide();
   $('.btn_start_play').show();
}
function status(msg){
   $('.suggest').text(msg);
}
//=============//
function play_mine(audio,id_user){
   Wami.startPlaying("http://"+location.host+"/js/data_record/record/"+audio+"","onPlayStart_mine("+id_user+")", "onPlayFinish_mine("+id_user+")", "onError");
}
function onPlayStart_mine(id_user){
   $('#user_answer .start_play_user').hide();
   $('#user_answer .stop_play_user').show();
}
function onPlayFinish_mine(id_user){
   $('#user_answer .start_play_user').show();
   $('#user_answer .stop_play_user').hide();
}
//==============//
function play_user(audio,uniq){
   Wami.startPlaying("http://"+location.host+"/js/data_record/record/"+audio+"","onPlayStart_user("+uniq+")", "onPlayFinish_user("+uniq+")", "onError");
}

function onPlayStart_user(uniq){
   $('.start_play_'+uniq).hide();
   $('.stop_play_'+uniq).show();
}

function onPlayFinish_user(uniq){
   $('.start_play_'+uniq).show();
   $('.stop_play_'+uniq).hide();
}