//app.js
const api = require("utils/api.js");
App({
  onLaunch: function () {
    // 展示本地存储能力
    var that = this
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        var url = 'wxData'
        //获取openid
        wx.request({
          url: getApp().api(url),
          header: {
            'content-type': 'application/json'
          },
          data: {
            code: res.code
          },
          success:function(ren){
           // console.log(ren)
            wx.setStorage({
              key: 'openid',
              data: ren.data.openid,
            })

            var openid = ren.data.openid
            getApp().globalData.openid = openid

            //将用户的信息存入数据库
            wx.getUserInfo({
              success: res=>{
            
               wx.setStorage({
                 key: 'user',
                 data: res.userInfo,
               })
                
                typeof cb == "function" && cb(that.globalData.userInfo);

                var user = res.userInfo;
                var nickname = user.nickName;
                var avatarUrl = user.avatarUrl;
              
              var url = 'infoAdd'
              wx.request({
                url: getApp().api(url),
                data: {
                  nickname: nickname,
                  avatar: avatarUrl,
                  openid: openid,
                },
                method: 'GET',
                success: function (res) {
                 //  console.log(res)
                }

              })


              }
            })
          }
        })

      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })
  },
  getCache: function (key) {
    var value = undefined;
    try {
      var value = wx.getStorageSync(key)
    } catch (e) {

    }
    return value;

  },
  setCache: function (key, value) {
    wx.setStorage({
      key: 'key',
      data: 'value',
    })
  },

  globalData: {
    userInfo: null,
  },
  api:api.api
})