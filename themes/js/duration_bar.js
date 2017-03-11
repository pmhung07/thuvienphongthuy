var strname = '';
var count_rc = 0;

function zxcAnimate(mde,obj,srt){
   this.to=null;
   this.obj=typeof(obj)=='object'?obj:document.getElementById(obj);
   this.mde=mde.replace(/\W/g,'');
   this.data=[srt||0];
   return this;
}

zxcAnimate.prototype.animate=function(srt,fin,ms,scale,c){
   clearTimeout(this.to);
   this.time=ms||this.time||0;
   this.neg=srt<0||fin<0;
   this.data=[srt,srt,fin];
   this.mS=this.time*(!scale?1:Math.abs((fin-srt)/(scale[1]-scale[0])));
   this.c=typeof(c)=='string'?c.charAt(0).toLowerCase():this.c?this.c:'';
   this.inc=Math.PI/(2*this.mS);
   this.srttime=new Date().getTime();
   this.cng();
}

zxcAnimate.prototype.cng=function(){
   var oop=this,ms=new Date().getTime()-this.srttime;
   this.data[0]=(this.c=='s')?(this.data[2]-this.data[1])*Math.sin(this.inc*ms)+this.data[1]:(this.c=='c')?this.data[2]-(this.data[2]-this.data[1])*Math.cos(this.inc*ms):(this.data[2]-this.data[1])/this.mS*ms+this.data[1];
   this.apply();
   if (ms<this.mS) this.to=setTimeout(function(){oop.cng()},10);
   else {
   this.data[0]=this.data[2];
   this.apply();
   if (this.Complete) this.Complete(this);
   }
}

zxcAnimate.prototype.apply=function(){
   if (isFinite(this.data[0])){
      if (this.data[0]<0&&!this.neg) this.data[0]=0;
      if (this.mde!='opacity') this.obj.style[this.mde]=Math.floor(this.data[0])+'px';
      else zxcOpacity(this.obj,this.data[0]);
   }
}

function zxcOpacity(obj,opc){
   if (opc<0||opc>100) return;
   obj.style.filter='alpha(opacity='+opc+')';
   obj.style.opacity=obj.style.MozOpacity=obj.style.WebkitOpacity=obj.style.KhtmlOpacity=opc/100-.001;
}

//==============================================//
function Bar(o){
   var obj=document.getElementById(o.ID);
   this.oop=new zxcAnimate('width',obj,0);
   this.max=obj.parentNode.offsetWidth;
   this.to=null;
}

Bar.prototype={

 Start:function(sec){
  clearTimeout(this.to);
  this.oop.animate(0,this.max,sec*1000);
  this.srt=new Date();
  this.sec=sec;
  this.Time();
 },

 Time:function(sec){
  var oop=this,sec=this.sec-Math.floor((new Date()-this.srt)/1000);
  //this.oop.obj.innerHTML=sec+' seconds';
  if (sec>0){
   this.to=setTimeout(function(){ oop.Time(); },1000);
  }else{
   //alert('Finished');
  }
 }
}