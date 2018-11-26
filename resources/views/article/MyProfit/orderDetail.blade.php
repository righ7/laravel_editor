

<div id="app">
    <Row type="flex" justify="center" align="middle">
        <i-col span="23" style="margin-top: 20px;">
            <!--<i-input v-model="searchArr.articleid" placeholder="文章id" style="width: 200px;"></i-input>-->
            <i-input v-model="searchArr.goodsid" placeholder="产品id" style="width: 200px;"></i-input>
            <!--<i-input v-model="searchArr.title" placeholder="标题" style="width: 200px;"></i-input>-->
            <!--<i-input v-model="searchArr.account" placeholder="发布账号" style="width: 200px;"></i-input>-->
            <radio-group v-model="searchArr.disabledGroup">
                <Radio label="按订单开始时间"></Radio>
                <Radio label="按订单结算时间"></Radio>
            </radio-group>
            <date-picker v-model="searchArr.time" @on-change="dateValueFormat" type="daterange" placeholder="请选择时间" format="yyyy-MM-dd HH:mm:ss" style="width: 300px"></date-picker>
            <i-button type="primary" @click="search">搜索</i-button>
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle">
        <i-col span="23" style="margin-top: 20px">
            <i-table :data="tableData" :columns="tableColumns" stripe></i-table>
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle">
        <i-col style="margin-top: 20px">
            <Page
                    :total="amount"
                    size="small"
                    :page-size="pageSize"
                    show-total
                    show-elevator
                    @on-change="pageChange"
            ></Page>
        </i-col>
    </Row>
    <back-top></back-top>
</div>

<script>
    let vm = new Vue({
        el: '#app',
        data() {
            return {
                tableColumns: [
                    {
                        title: '标题',
                        key: 'title',
                        width: 315,
                        render (h,params){
                            let row = params.row;
                            let text = row.title;
                            //return h('span',text);
                            return h('a', {
                                attrs: {
                                    href:row.a_href,
                                    target: "view_window"
                                }
                            }, text);
                        }
                    },
                    {
                        title: '店铺名',
                        key: 'shop_name',
                        // width: 100
                    },
                    {
                        title: '订单id',
                        key: 'order_id',
                        width: 160
                    },
                    {
                        title: '商品',
                        key: 'goods_name',
                        width: 320,
                        render (h,params){
                            let row = params.row;
                            let text = row.goods_name;
                            console.log(text);
                            return h('a',{
                                attrs:{
                                    href:row.goods_link,
                                    target: "view_window"
                                }
                            },text);
                        }
                    },
                    {
                        title: '销售金额',
                        key: 'order_price',
                        // width: 80
                    },
                    {
                        title: '预估效果',
                        key: 'recprice',
                        // width: 70
                    },
                    {
                        title: '订单状态',
                        key: 'order_status',
                        // width: 70
                    },
                    {
                        title: '订单创建时间',
                        key: 'create_time',
                        // width: 80
                    },
                    {
                        title: '订单结束时间',
                        key: 'end_time',
                        // width: 80
                    },
                    {
                        title: '结算完成时间',
                        key: 'settle_time',
                        // width: 80
                    }
                ],
                tableData: [],
                searchArr: {
                    // title: '',
                    // author: '',
                    // zuzhang: '',
                    // account: '',
                    goodsid:'',
                    time: '',
                    disabledGroup:'按订单开始时间'
                },
                pageSize: 100,
                amount: 0,
            }
        },
        methods: {
            getInitialData() {
                var url = document.location.toString();
                var arrObj = url.split("?");
                var article_id;
                if (arrObj.length > 1) {
                    var arrPara = arrObj[1].split("&");
                    var arr;
                    for (var i = 0; i < arrPara.length; i++) {
                        arr = arrPara[i].split("=");

                        if (arr != null && arr[0] == 'article_id') {
                            article_id=arr[1];
                        }
                    }
                }
                else {
                    article_id='';
                }
                axios.get("{{ route('article.getOrderData') }}", {
                    params: {
                        page_index: 1,
                        page_size: this.pageSize,
                        article_id:article_id
                    }
                })
                .then(function (response) {
                    //console.log(response)
                    for (var i=0;i<response.data.data.length;i++){
                        if (response.data.data[i].create_time){
                            response.data.data[i].create_time=response.data.data[i].create_time.substr(0,10)
                        }
                        if (response.data.data[i].end_time){
                            response.data.data[i].end_time=response.data.data[i].end_time.substr(0,10)
                        }
                        if (response.data.data[i].settle_time){
                            response.data.data[i].settle_time=response.data.data[i].settle_time.substr(0,10)
                        }
                    }
                    vm.tableData = response.data.data;
                    vm.amount = response.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            search() {
                var url = document.location.toString();
                var arrObj = url.split("?");
                var article_id;
                if (arrObj.length > 1) {
                    var arrPara = arrObj[1].split("&");
                    var arr;
                    for (var i = 0; i < arrPara.length; i++) {
                        arr = arrPara[i].split("=");

                        if (arr != null && arr[0] == 'article_id') {
                            article_id=arr[1];
                        }
                    }
                }
                else {
                    article_id='';
                }
                axios.get("{{ route('article.getOrderData') }}", {
                    params: {
                        page_index: 1,
                        page_size: this.pageSize,
                        searchArr: this.searchArr,
                        article_id:article_id
                    }
                })
                    .then(function (response) {
                        for (var i=0;i<response.data.data.length;i++){
                            if (response.data.data[i].create_time){
                                response.data.data[i].create_time=response.data.data[i].create_time.substr(0,10)
                            }
                            if (response.data.data[i].end_time){
                                response.data.data[i].end_time=response.data.data[i].end_time.substr(0,10)
                            }
                            if (response.data.data[i].settle_time){
                                response.data.data[i].settle_time=response.data.data[i].settle_time.substr(0,10)
                            }
                        }
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },


            pageChange(index) {
                window.scrollTo(0,0); // 触发回到顶部，再加载数据
                console.log(index)
                var url = document.location.toString();
                var arrObj = url.split("?");
                var article_id;
                if (arrObj.length > 1) {
                    var arrPara = arrObj[1].split("&");
                    var arr;
                    for (var i = 0; i < arrPara.length; i++) {
                        arr = arrPara[i].split("=");

                        if (arr != null && arr[0] == 'article_id') {
                            article_id=arr[1];
                        }
                    }
                }
                else {
                    article_id='';
                }
                axios.get("{{ route('article.getOrderData') }}", {
                    params: {
                        page_index: index,
                        page_size: this.pageSize,
                        searchArr: this.searchArr,
                        article_id:article_id
                    }
                })
                    .then(function (response) {
                        //console.log(response)
                        for (var i=0;i<response.data.data.length;i++){
                            if (response.data.data[i].create_time){
                                response.data.data[i].create_time=response.data.data[i].create_time.substr(0,10)
                            }
                            if (response.data.data[i].end_time){
                                response.data.data[i].end_time=response.data.data[i].end_time.substr(0,10)
                            }
                            if (response.data.data[i].settle_time){
                                response.data.data[i].settle_time=response.data.data[i].settle_time.substr(0,10)
                            }
                        }
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            dateValueFormat(f,v){
                this.searchArr.time = f;
            }
        }
    });

    vm.getInitialData();
</script>