var ractive=new Ractive({el:"#container",template:"#template",data:{progressbars:[{name:"progress#1",value:0},{name:"progress#2",value:0},{name:"progress#3",value:0}],amounts:[10,38,-13,-18]},adjust:function(a){var b=this.get("selectedProgress");if(null!=b){var c="progressbars["+b+"].value",d=Math.max(0,this.get(c));d>0&&0>a&&0>d+a?this.add(c,~d+1):0==d&&0>a?this.add(c,0):this.add(c,a)}}});