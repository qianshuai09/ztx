// pages/components/authentication/authentication.js
const app = getApp();
Page({

    /**
     * 页面的初始数据
     */
    data: {
        idCard_zheng: '../../../image/idcard-zheng.png',
        idCard_fan: '../../../image/idcard-fan.png',
        xuesheng: '../../../image/xuesheng.png',
        shetuan: '../../../image/shetuan.png'
    },

    nameInput: function (e) {
        this.setData({
            name: e.detail.value
        })
    },

    phoneInput: function (e) {
        this.setData({
            phone: e.detail.value
        })
    },

    idInput: function (e) {
        this.setData({
            idnum: e.detail.value
        })
    },

    cardInput: function (e) {
        this.setData({
            card: e.detail.value
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
                if (id === 'idCard_zheng') {
                    _this.setData({
                        idCard_zheng: temp
                    })
                } else if (id === 'idCard_fan') {
                    _this.setData({
                        idCard_fan: temp
                    })
                }
                else if (id === 'xuesheng') {
                    _this.setData({
                        xuesheng: temp
                    })
                }
                else if (id === 'shetuan') {
                    _this.setData({
                        shetuan: temp
                    })
                }

            }
        })
    },


    submitInfo: function () {
        var _this = this;
        var openid = getApp().getCache('openid');
        var img = [this.data.idCard_zheng, this.data.idCard_fan, this.data.xuesheng, this.data.shetuan];


        if (!this.data.name) {
            wx.showModal({
                title: '真实姓名为空',
                content: '请填写您的真实姓名',
                showCancel: false
            })
            return
        }

        if (!this.data.phone) {
            wx.showModal({
                title: '手机号为空',
                content: '请填写您的手机哈',
                showCancel: false
            })
            return
        }
        if (!this.data.idnum) {
            wx.showModal({
                title: '身份证号为空',
                content: '请填写您的身份证号',
                showCancel: false
            })
            return
        }
        if (!this.data.card) {
            wx.showModal({
                title: '学生证号为空',
                content: '请填写您的学生证号',
                showCancel: false
            })
            return
        }


        wx.showLoading({
            title: '提交中',
        })



        //上传身份证（正）
        var uploadUrl = 'upload';
        wx.uploadFile({
            url: getApp().api(uploadUrl),
            filePath: _this.data.idCard_zheng,
            name: 'file',
            header: {
                "Content-Type": "multipart/form-data"
            },
            success: function (res) {
                console.log("身份证地址1" + res.data)
                _this.setData({
                    idBphoto: res.data    //给第一张图片赋值
                })

                //上传身份证照片（反）
                wx.uploadFile({
                    url: getApp().api(uploadUrl),
                    filePath: _this.data.idCard_fan,
                    name: 'file',
                    header: {
                        "Content-Type": "multipart/form-data"
                    },
                    success: function (res) {
                        console.log("身份证反面地址：" + res.data)
                        _this.setData({
                            idFphoto: res.data   //给第二张图片赋值
                        })

                        //上传学生证（内容面）
                        wx.uploadFile({
                            url: getApp().api(uploadUrl),
                            filePath: _this.data.xuesheng,
                            name: 'file',
                            header: {
                                "Content-Type": "multipart/form-data"
                            },
                            success: function (res) {
                                console.log("学生证地址：" + res.data)
                                _this.setData({
                                    stuphoto: res.data  //给第三张图片赋值
                                })

                                //上传社团工作证
                                wx.uploadFile({
                                    url: getApp().api(uploadUrl),
                                    filePath: _this.data.shetuan,
                                    name: 'file',
                                    header: {
                                        "Content-Type": "multipart/form-data"
                                    },
                                    success: function (res) {
                                        console.log("社团工作证地址：" + res.data)
                                        _this.setData({
                                            clubphoto: res.data //给第四张图片赋值
                                        })

                                        //点击提交所有信息存入数据库字段
                                        var cerUrl = "certification"
                                        wx.request({
                                            url: getApp().api(cerUrl),
                                            header: {
                                                "Content-Type": "application/json"
                                            },
                                            data: {
                                                openid: openid,
                                                name: _this.data.name,
                                                phone: _this.data.phone,
                                                idnumber: _this.data.idnum,
                                                bnumber: _this.data.card,
                                                front: _this.data.idBphoto,
                                                back: _this.data.idFphoto,
                                                stuphoto: _this.data.stuphoto,
                                                clubphoto: _this.data.clubphoto
                                            },
                                            success: function (res) {
                                                console.log(res)
                                                wx.hideLoading();
                                                console.log(res)
                                                if (res.data.code == 1000) {
                                                  wx.showModal({
                                                    title: '提交成功',
                                                    content: '请等待审核',
                                                    showCancel: false,
                                                    success: function (res) {
                                                      if (res.confirm) {
                                                        wx.navigateBack({

                                                        })
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

                    }
                })
            }
        })





    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {

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