// pages/components/joinus/joinus.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

    disabled_love: false,
    disabled_apply: false,
    btnText_love: "喜欢",
    btnText_apply: "申请",
  },



  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var pid = options.pid;
    this.setData({
      'pid': pid
    })
    var urlDetail = 'detail';
    var _this = this
    wx.request({
      url: getApp().api(urlDetail),
      data: {
        pid: pid,
        openid: getApp().getCache('openid')
      },
      success: function (res) {
        console.log(res)
        _this.setData({
          'detail': res.data.data,
          'img': res.data.img
        })


      }
    })

    var oid = options.oid;
    var urlComment = 'comment';
    var _this = this

    wx.request({
      url: getApp().api(urlComment),
      data: {
        oid: oid,
      },
      success: function (res) {
        console.log(res)
        _this.setData({
          'comment': res.data.data,
          'imgs': res.data.img.urls   
               })
      }
    })






  },

  loveTap: function () {
    var _this = this
    var pid = this.data.pid;
    console.log("########" + pid)
    var loveUrl = 'love';
    wx.request({
      url: getApp().api(loveUrl),
      data: {
        pid: pid,
        openid: getApp().getCache('openid')
      },
      success: function (res) {
        console.log(res)
        if (res.data.code == 1000) {
          wx.showToast({
            title: '喜欢上啦',
            success: function () {
              //页面刷新
              _this.setData({
                disabled_love: !_this.data.disabled,
                btnText_love: '已喜欢'
              })

            }
          })
          return
        }
      }
    })
  },





  applyTap: function () {

    var _this = this
    var pid = this.data.pid;
    var applyUrl = 'apply';
    var identy = 'identy';
    console.log("########" + pid)
    wx.request({
      url: getApp().api(identy),
      data: {
        openid: getApp().getCache('openid')
      },
      success: function (res) {
        if (res.data == 1) {
          wx.showToast({
            title: '实名认证审核中...',
          })
        }
          if (res.data == 2) {
        
            wx.request({
              url: getApp().api(applyUrl),
              data: {
                pid: pid,
                openid: getApp().getCache('openid')
              },
              success: function (res) {
                if (res.data.code == 1000) {
                  wx.showToast({
                    title: '申请上啦',
                    success: function () {
                      //页面刷新
                      _this.setData({
                        disabled_apply: !_this.data.disabled,
                        btnText_apply: '已申请'
                      })
                    }
                  })

                  return
                }
              }
            })
        }
          if (res.data == 3) {
          
            wx.navigateTo({
              url: '../authentication/authentication'
            })
         }
     }
   })
},

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})