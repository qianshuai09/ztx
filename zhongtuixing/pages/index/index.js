
var app = getApp()
//var openid = getApp().globalData.openid; 
var openid = app.getCache('openid')
Page({
  data: {
    btnText_apply: "申请",
    idx: 0,
    actionSheetHidden: false,
    cid:1,
    p:1,
    processing:false,
    detail:[],
    loadingHidden:true
  },

  actionSheetTap: function () {
    this.setData({
      actionSheetHidden: !this.data.actionSheetHidden
    })
  },


onLoad: function () {

  //  wx.showLoading({
  //    title: '加载中',
  //  })
  this.banner();
  this.category();
  this.detail();
},  

 //banner图加载
 banner:function(){
   var urlBanner = 'banner'
   var _this = this
   wx.request({
     url: app.api(urlBanner),
     method: "GET",
     data: {
       bid: 1
     },
     success: function (res) {

       _this.setData({
         'movies': res.data.urls
       })
     }
   })
 },

 //分类列表加载
 category:function(){
   var urlcateroy = 'category'
    var _this = this
    wx.request({
      url: app.api(urlcateroy),
      method: "GET",
      success: function (res) {
        console.log(res)

         _this.setData({
           'list': res.data
         })
      }
    })
 },

 //点击分类按钮
 goIndex:function(e){
   var cid = e.currentTarget.dataset.cid;
   let index = e.currentTarget.dataset.index;
   this.setData({
     idx: index,
     p:1,
     detail:[],
     cid:cid,
     loadingHidden: true,
     processing: false,
     
   })
   this.detail()
  
 },

 //产品展示：
 detail:function(){
   wx.showLoading({
     title: '加载中',
   })
   
   var urlDetail = 'activeCategoryt'
   var _this = this
   if(_this.data.processing){
     return;
   }
   if (!_this.data.loadingHidden){
      wx.hideLoading()
      return;
   }

   _this.setData({
     processing:true
   });

   wx.request({
     url: app.api(urlDetail),
     method: "GET",
     data:{
       openid:getApp().getCache('openid'),
       cid:_this.data.cid,
       p:_this.data.p
     },
     success: function (res) {
       wx.hideLoading()
       console.log(res)
       var goods = res.data.active;
       _this.setData({
         detail: _this.data.detail.concat(goods),
         p:_this.data.p+1,
         processing:false,
       });
       if(res.data.status==0){
         _this.setData({
           loadingHidden:false
         })
       }
     }
   })
 },

//  页面跳转
goDetail:function(e){  
  var cid = e.currentTarget.dataset.cid;
  var pid = e.currentTarget.dataset.pid;

  if(cid==1){
     wx.navigateTo({
       url: '../components/sponsor/sponsor?pid='+pid,
     })
  }
  if (cid == 2) {
    wx.navigateTo({
      url: '../components/work/work?pid='+pid,
    })
  }
  if (cid == 3) {
    wx.navigateTo({
      url: '../components/activity/activity?pid='+pid,
    })
  }
},

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
     var _this = this;
     setTimeout(function(){
         _this.detail()
     },500)
  },

  onShareAppMessage: function () {
    // 用户点击右上角分享
    return {
      title: '众实践', // 分享标题
      desc: '哎哟不错哦', // 分享描述
      path: 'pages/index/index' // 分享路径
    }
  }
})
