
<div id="app">
    <Row type="flex" justify="center" align="middle">
        <i-col span="23" style="margin-top: 20px;">
            <i-input v-model="searchArr.title" placeholder="标题" style="width: 200px;"></i-input>
            <i-input v-model="searchArr.account" placeholder="特卖账号" style="width: 200px;"></i-input>
            <i-input v-model="searchArr.author" placeholder="作者" style="width: 200px;"></i-input>
            <i-input v-model="searchArr.zuzhang" placeholder="组长名" style="width: 100px;"></i-input>
            <i-select v-model="searchArr.type" placeholder="文章类型" style="width:120px">
                <i-option  value="-1" key="-1">全部</i-option>
                <i-option  value="0" key="0">图集</i-option>
                <i-option  value="1" key="1">专辑</i-option>
            </i-select>
            <i-select v-model="searchArr.order_status" placeholder="订单状态" style="width:120px">
                <i-option  value="0" key="0">全部</i-option>
                <i-option  value="1" key="1">已结算</i-option>
            </i-select>
            </i-select>
            <date-picker v-model="searchArr.time" @on-change="dateValueFormat" type="daterange" placeholder="上线时间" format="yyyy-MM-dd HH:mm:ss" style="width: 300px"></date-picker>
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
                        title: '特卖文章id',
                        key: 'article_id',
                        width: 170
                    },
                    {
                        title: '作者',
                        key: 'nickname',
                        width: 80
                    },
                    {
                        title: '组长',
                        key: 'zuzhang_name',
                        width: 80
                    },
                    {
                        title: '标题',
                        key: 'title',
                        // width: 265,
                        render (h,params){
                            let row = params.row;
                            let text = row.title;
                            return h('a', {
                                attrs: {
                                    href:row.a_href,
                                    target: "view_window"
                                }
                            }, text);
                        }
                    },
                    {
                        title: '写作记录类别',
                        key: 'article_type',
                        width:95,
                        render (h,param){
                            let text = '';
                            let color = '';
                            switch(Number(param.row.article_type)){
                                case 0:
                                    text = '图集';
                                    color = 'primary';
                                    break;
                                case 1:
                                    text = '专辑';
                                    color = 'success';
                                    break;
                            }
                            return h('Tag',{
                                props:{
                                    color:color
                                }
                            },text);
                        }
                    },
                    {
                        title: '推荐数',
                        key: 'recommend_count',
                        width: 90
                    },
                    {
                        title: '浏览数',
                        key: 'view_count',
                        width: 80
                    },
                    {
                        title: '点击数',
                        key: 'product_click_count',
                        width: 80
                    },
                    {
                        title: '预估效果',
                        key: 'order_effect.recprice_all',
                        width: 80,
                        render (h,params){
                            let row = params.row;
                            let text = row.order_effect.recprice_all;
                            console.log(text);
                            return h('span',text);
                        }
                    },
                    {
                        title: '销售金额',
                        key: 'order_effect.all_price',
                        width: 90,
                        render (h,params){
                            let row = params.row;
                            let text = row.order_effect.all_price;
                            console.log(text);
                            return h('span',text);
                        }
                    },
                    {
                        title: '销售数量',
                        key: 'order_effect.all_count',
                        width: 90,
                        render (h,params){
                            let row = params.row;
                            let text = row.order_effect.all_count;
                            console.log(text);
                            return h('a',{
                                attrs:{
                                    href:'<?php echo e(route('article.orderDetail')); ?>'+'?article_id='+row.article_id,
                                    style:'background: #5cb85c !important;color:white;border-radius:4px;padding:0 6px'
                                }
                            },text);
                        }
                    },
                    {
                        title: '上线时间',
                        key: 'online_time',
                        width: 140
                    }
                ],
                tableData: [],
                recprice: [],
                searchArr: {
                    title: '',
                    author: '',
                    zuzhang: '',
                    account: '',
                    type: '',
                    time: '',
                },
                pageSize: 100,
                amount: 0,
                initialtime: ''
            }
        },
        methods: {
            getRevenueInitialData() {
                axios.get("<?php echo e(route('article.get_all_initial_data')); ?>", {
                    params: {
                        page_index: 1,
                        page_size: this.pageSize
                    }
                })
                .then(function (response) {
                    vm.tableData = response.data.data;
                    vm.amount = response.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            setDate(date){
                y=date.getFullYear();
                m=date.getMonth()+1;
                d=date.getDate();

                m=m<10?"0"+m:m;
                d=d<10?"0"+d:d;
                return y+"-"+m+"-"+d;
            },
            formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                return [year, month, day].join('-');
            },
            search() {
                axios.get("<?php echo e(route('article.get_all_initial_data')); ?>", {
                    params: {
                        page_index: 1,
                        page_size: this.pageSize,
                        searchArr: this.searchArr
                    }
                })
                    .then(function (response) {
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            pageChange(index) {
                window.scrollTo(0,0); // 触发回到顶部，再加载数据
                axios.get("<?php echo e(route('article.get_all_initial_data')); ?>", {
                    params: {
                        page_index: index,
                        page_size: this.pageSize,
                        searchArr: this.searchArr
                    }
                })
                    .then(function (response) {
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            dateValueFormat(f,v){
                this.initialtime=''
                this.searchArr.time = f;
            }
        }
    });

    vm.getRevenueInitialData();
</script>