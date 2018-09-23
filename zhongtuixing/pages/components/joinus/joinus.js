// pages/components/joinus/joinus.js
const app = getApp();
Page({

    /**
     * 页面的初始数据
     */
    data: {
        idCardF: '../../../image/mianguan.png',
        idCardB: '../../../image/idcard-zheng.png'
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {

    },

    nameInput: function (e) {

        this.setData({
            name: e.detail.value
        })
    },
    idInput: function (e) {
        this.setData({
            idnum: e.detail.value
        })
    },

    phoneInput: function (e) {
        this.setData({
            phone: e.detail.value
        })
    },

    schoolInput: function (e) {
        this.setData({
            school: e.detail.value
        })
    },

    cardInput: function (e) {
        this.setData({
            card: e.detail.value
        })
    },
    weixinInput: function (e) {
    this.setData({
      wxnum: e.detail.value
    })
  },

    imgUpload: function (e) {
        var id = e.currentTarget.dataset.id;
        var _this = this;
        wx.chooseImage({
            count: 1,
            sizeType: ['original'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var temp = res.tempFilePaths[0];
                if (id === 'idCardF') {
                    _this.setData({
                        idCardF: temp
                    })
                } else if (id === 'idCardB') {
                    _this.setData({
                        idCardB: temp
                    })
                }
            }
        })
    },


    submitInfo: function () {
        var _this = this;
        var openid = getApp().getCache('openid');
        var img = [this.data.idCardF, this.data.idCardB];
        if (!this.data.name) {
            wx.showModal({
                title: '姓名为空',
                content: '请填写您的姓名',
                showCancel: false
            })
            return
        }
        if (!this.data.idnum) {
            wx.showModal({
                title: '支付宝号为空',
                content: '请填写您的支付宝号',
                showCancel: false
            })
            return
        }
        if (!this.data.phone) {
            wx.showModal({
                title: '手机号为空',
                content: '请填写您的手机号',
                showCancel: false
            })
            return
        }
        if (!this.data.school) {
            wx.showModal({
                title: '学校为空',
                content: '请填写您的学校',
                showCancel: false
            })
            return
        }
      /*if (!this.data.card) {
            wx.showModal({
                title: '学生证号为空',
                content: '请填写您的学生证号',
                showCancel: false
            })
            return
        }*/


        wx.showLoading({
            title: '提交中',
        })

        //上传个人免冠图片
        var uploadUrl = 'upload';
        wx.uploadFile({
            url: getApp().api(uploadUrl),
            filePath: _this.data.idCardF,
            name: 'file',
            header: {
                "Content-Type": "multipart/form-data"
            },
            success: function (res) {
                console.log(res.data)
                _this.setData({
                    uploadIdF: res.data
                })
                //上传身份证照片
                wx.uploadFile({
                    url: getApp().api(uploadUrl),
                    filePath: _this.data.idCardB,
                    name: 'file',
                    header: {
                        "Content-Type": "multipart/form-data"
                    },
                    success: function (res) {
                        _this.setData({
                            uploadIdB: res.data
                        })

                        //点击提交所有信息存入数据库字段
                        var joinUrl = 'joinUs'
                        wx.request({
                            url: getApp().api(joinUrl),
                            header: {
                                "Content-Type": "application/json"
                            },
                            data: {
                                openid: openid,
                                name: _this.data.name,
                                idnum: _this.data.idnum,
                                phone: _this.data.phone,
                                school: _this.data.school,
                                card: _this.data.card,
                                photo: _this.data.uploadIdF,
                                idimg: _this.data.uploadIdB,
                                wxnum: _this.data.wxnum,
                            },
                            success: function (res) {
                                wx.hideLoading();
                                console.log(res)
                                if (res.data.code == 1000) {
                                    wx.showModal({
                                        title: '提交成功',
                                        content: '我们近期与您联系',
                                        showCancel: false,
                                        success: function (res) {
                                            if (res.confirm) {
                                                wx.navigateBack({})
                                            }
                                        }
                                    })
                                }
                            }
                        })

                    }
                })



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