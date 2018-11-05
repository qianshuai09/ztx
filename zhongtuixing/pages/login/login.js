//login.js
//获取应用实例
var app = getApp();
Page({
  data: {
    remind: '加载中',
    angle: 0,
    userInfo: {}
  },
 
  onLoad: function () {

    wx.showLoading({
      title: '加载中',
    })
  
    wx.setNavigationBarTitle({
      title: app.globalData.shopName
    });
    this.checkLogin()

  },
  onShow: function () {

  },
  onReady: function () {
    var that = this;
    setTimeout(function () {
      that.setData({
        remind: ''
      });
    }, 1000);
    wx.onAccelerometerChange(function (res) {
      var angle = -(res.x * 30).toFixed(1);
      if (angle > 14) { angle = 14; }
      else if (angle < -14) { angle = -14; }
      if (that.data.angle !== angle) {
        that.setData({
          angle: angle
        });
      }
    });
  },

  checkLogin:function(){
    wx.login({
      success:function(res){
        if (!res.code) {
          app.alert({ 'content': '登陆失败，请再次点击' });
          return;
        }
        var path = "checkOpenid";
        // 查询是否该用户已经注册
        wx.request({
          url: app.api(path),
          data:{
            code:res.code
          },
          success: function (res) {
            console.log(res.data.openid)
            if(res.data.code==1000){
              // 已经注册
              wx.setStorage({
                key: 'openid',
                data: res.data.openid,
              })
                wx.switchTab({
                url: '../index/index',
              })
            }else{
              // 尚未注册
              wx.hideLoading()
            }
          }
        })
      }
    }); 
  },

  login: function (e) {
    if (!e.detail.userInfo) {
      app.alert({ 'content': '登陆失败，请再次点击' });
      return;
    }
    var data = e.detail.userInfo;
    var info = "infomationAdd";
    wx.login({
      success: function (res) {
        if (!res.code) {
          app.alert({ 'content': '登陆失败，请再次点击' });
          return;
        }
        data['code'] = res.code
        wx.request({
          url:app.api(info),
          data: {
            code:res.code,
            avatar: data.avatarUrl,
            nickname: data.nickName
          },
          success: function (res) {
            if(res.data.code==2002){
              wx.setStorage({
              key: 'openid',
              data: res.data.openid,
            })
            wx.switchTab({
              url: '../index/index',
            })
            }
            if(res.data.code==2000){
              wx.setStorage({
                key: 'openid',
                data: res.data.openid,
              })
         
              wx.switchTab({
                url: '../index/index',
              })
            }
            if(res.data.code==4000){
              app.alert({ 'content': '登陆失败，请再次点击' })
            }
          }
        })
      }
    });
  }
});