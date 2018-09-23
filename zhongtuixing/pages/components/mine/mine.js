var app = getApp()
Page({
    data: {

        idstatus: "未认证",
        joinstatus: "未加入",
      actionSheetHidden: true,
      actionSheetItems: [
        { bindtap: 'Menu1', txt: '电话咨询' },
        { bindtap: 'Menu2', txt: '微信咨询' },
      ],
    },

  realName: function () {
    if (this.data.idstatus == '已认证') {
      wx.showToast({
        title: '您已认证',
      })
      return
    } else if (this.data.idstatus == '审核中') {
      wx.showToast({
        title: '请等待审核',
        icon: 'none'
      })
      return
    }
    wx.navigateTo({
      url: '../authentication/authentication',

    })
  },

  realJoin: function () {
    if (this.data.joinstatus == '已加入') {
      wx.showToast({
        title: '您已加入',
      })
      return
    }
    wx.navigateTo({
      url: '../joinus/joinus',

    })
  },

    calling: function () {
        wx.makePhoneCall({
            phoneNumber: '12345678900', //此号码并非真实电话号码，仅用于测试
            success: function () {
                console.log("拨打电话成功！")
            },
            fail: function () {
                console.log("拨打电话失败！")
            }
        })
    },


  actionSheetTap: function () {
    this.setData({
      actionSheetHidden: !this.data.actionSheetHidden
    })
  },
  actionSheetbindchange: function () {
    this.setData({
      actionSheetHidden: !this.data.actionSheetHidden
    })
  },
  bindMenu1: function () {
    this.setData({
      actionSheetHidden: !this.data.actionSheetHidden
    })
    wx.makePhoneCall({
      phoneNumber: '12345678900', //此号码并非真实电话号码，仅用于测试
      success: function () {
        console.log("拨打电话成功！")
      },
      fail: function () {
        console.log("拨打电话失败！")
      }
    })
  },

  bindMenu3: function () {
    this.setData({
      menu: 3,
      actionSheetHidden: !this.data.actionSheetHidden
    })
  },

    
  /**
   * 生命周期函数--监听页面加载
   */
    onShow: function () {



      var user = getApp().getCache("user");
      this.setData({
        'user':user
      })

        var statusUrl = "userStatus";
        wx.request({
            url: getApp().api(statusUrl),
            data: {
                openid: getApp().getCache('openid')
            },
            success: function (res) {
                console.log(res)
                var user = res.data.userstatus;
                var join = res.data.joinstatus;
                var id = '';  var ji = '';
                if (user == 0) {
                    id = '未认证'
                } else if (user == 1) {
                    id = '审核中'
                } else if (user == 2) {
                    id = '已认证'
                } else if (user == 3) {
                    id = '未通过'
                }

                if(join == 1){
                   ji = "未加入"
                }else if(join==2){
                   ji = "已加入"
                }

                this.setData({
                  idstatus:id,
                  joinstatus:ji
                })
            }.bind(this)
        })


    }
    ,

    onShareAppMessage: function () {
        // 用户点击右上角分享
        return {
            title: '众推行', // 分享标题
            desc: '哎哟不错哦', // 分享描述
            path: 'pages/index/index' // 分享路径
        }
    }


})