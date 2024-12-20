import axios from "axios";
import {Validator} from "vee-validate";
import {Toast} from "vue-toastification";


export default {
    data() {
        return {

        };
    },


    methods: {
        getDataList: function (page = 1) {
            const _this = this;
            axios.get(_this.urlGenaretor(), {
                params: {
                    page: page,
                    // filter: _this.formFilter,
                }
            })
                .then(function (res) {
                    if (parseInt(res.data.status) === 2000) {
                        _this.$store.commit("dataList", res.data.result);

                    } else if (parseInt(res.data.status) === 5000) {
                        // Handle error case
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        },


        getRequiredData: function (array) {
            const _this = this;
            _this.httpReq('post', _this.urlGenaretor('api/required_data'), array, {}, function (retData) {
                $.each(retData.result, function (eachItem, value) {
                    _this.$set(_this.requireData, eachItem, value);
                });
            });
        },
        httpReq: function (method, url, data = {}, params = {}, callback = false) {

            axios({
                method: method,
                url: url,
                data: data,
                params: params
            }).then(function (res) {
                if (parseInt(res.data.result) === 5000) {
                    return;

                }
                if (parseInt(res.data.result) === 3000) {
                    return;

                }
                if (typeof callback === 'function') {
                    callback(res.data);
                }
            })

        },
        submitFrom() {
            const _this = this;

            if (_this.fromData.password !== _this.fromData.confirmPassword) {
                _this.errorMessage = "Passwords do not match.";
                return;
            }

            axios.post('/api/frontend/seekerregis', _this.fromData)
                .then(function (res) {
                    if (parseInt(res.data.status) === 2000) {
                        _this.$toast.success("Registered successfully!");
                        _this.$router.push('/seekerlogin');
                    } else {
                        _this.$toast.error("Registration failed!");
                    }
                })
                .catch(function (error) {
                    if (error.response) {
                        _this.errorMessage = error.response.data.message || "An error occurred.";
                    }
                });
        },


        submitFromData: function (fromData = {}, optParms = {}, callback) {
            const _this = this;

            let method = (_this.formType === 2 && _this.updateId) ? 'put' : 'post';
            let url = (_this.formType === 2 && _this.updateId) ? `${_this.urlGenaretor()}/${_this.updateId}` : _this.urlGenaretor();

            _this.$validator.validateAll().then(valid => {
                if (valid) {
                    axios({
                        method: method,
                        url: url,
                        data: fromData

                    }).then(function (res) {
                        if (parseInt(res.data.status) === 2000) {

                            if (optParms.modalForm === undefined) {
                                _this.closeModal();
                            }
                            if (optParms.reloadList === undefined) {
                                _this.getDataList();
                            }
                            if (typeof callback === 'function') {
                                callback(res.data.result);
                            }
                            _this.$toast.success("Data Submited successfully!");

                        } else if (parseInt(res.data.status) === 3000) {
                            $.each(res.data.result, function (index, errorValue) {
                                _this.$validator.errors.add({
                                    id: index,
                                    field: index,
                                    name: index,
                                    msg: errorValue[0],
                                });
                            })

                        } else {
                            _this.$toast.error("Data Submited  Unsuccessfully!");

                        }
                    });
                }
            });
        },


        CategoryDatadelete: function(id, index) {
            const _this = this;
            _this.DeleteToster((isConfirmed) => {
                if (isConfirmed) {
                    const url = `${_this.urlGenaretor()}/${id}`;
                    _this.httpReq('delete', url, {}, {}, (retData) => {
                        _this.getDataList();
                        _this.$toast.success("Data deleted successfully!");
                    });
                }
            });
        },


        uploadImage : function (event, dataObject, dataModel, callback = false) {
            const _this = this;

            var files = event.target.files[0];
            var form = new FormData();

            form.append('file', files);

            _this.httpReq('post', _this.urlGenaretor('api/upload'), form, {}, function (retData) {
                _this.$set(dataObject, dataModel, retData.result.name);
            })
        },




    }

}
