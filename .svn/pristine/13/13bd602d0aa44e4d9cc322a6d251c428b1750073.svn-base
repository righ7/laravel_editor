{{--@extends ('backend.layouts.index')--}}
{{--@section('content')--}}
<style>
    .demo-badge-alone{
        background: #5cb85c !important;
    }
    .demo-spin-col{
        height: 100px;
        position: relative;
        border: 1px solid #eee;
    }
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
    @keyframes ani-demo-spin {
        from { transform: rotate(0deg);}
        50%  { transform: rotate(180deg);}
        to   { transform: rotate(360deg);}
    }
</style>
<div id="app">
    {{--<Row>--}}
        {{--<h1 v-if="searchArr.article_type==0" style="margin:20px 0 0 30px">全网好文</h1>--}}
        {{--<h1 v-if="searchArr.article_type==1" style="margin:20px 0 0 30px">自有好文</h1>--}}
    {{--</Row>--}}
    <Row>
        <i-col span="13" style="margin:20px 0 0 26px">
            <i-button v-on:click="changeAtype(0)" type="success" style="margin-left: 11px"><span>全网</span><Icon v-if="searchArr.article_type==0" type="md-checkmark" /></i-button>
            <i-button v-on:click="changeAtype(1)" type="warning" style="margin-left: 16px">自有<Icon v-if="searchArr.article_type==1" type="md-checkmark" /></i-button>
            {{--<Badge text="全网" v-on:click="changeAtype(0)" ></Badge>--}}
            {{--<Badge text="自有" v-on:click="changeAtype(1)" class-name="demo-badge-alone" style="cursor: pointer;margin-left: 16px"></Badge>--}}
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle">
        <i-col span="23" style="margin-top: 20px;">
            <span>频道：</span>
            <Badge @click.native="changePlate('每日搭配之道')" text="每日搭配之道" status="success" style="cursor: pointer;margin-left: 16px"></Badge>
            <Badge @click.native="changePlate('潮男指南')" text="潮男指南" status="error" style="cursor: pointer;margin-left: 16px"></Badge>
            <Badge @click.native="changePlate('放心家居')" text="放心家居" status="processing" style="cursor: pointer;margin-left: 16px"></Badge>
            <date-picker v-model="searchArr.online_time" @on-change="dateValueFormat" type="daterange" placeholder="发布时间" format="yyyy-MM-dd" style="margin-left: 14px;width: 300px"></date-picker>
            <i-button type="primary" @click="search">搜索</i-button>
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle">
        <i-col span="23" style="margin-top: 20px">
            <i-table :height="tableHight" :data="tableData" :columns="tableColumns" stripe></i-table>
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle">
        <i-col style="margin-top: 20px">
            <Page
                    :total="amount"
                    :current="pageIndex"
                    size="small"
                    :page-size="pageCount"
                    show-total
                    show-elevator
                    @on-change="pageChange"
            ></Page>
        </i-col>
    </Row>
    <back-top></back-top>
</div>
{{--@stop--}}

{{--@section('after-scripts')--}}

<script>

    let vm = new Vue({
        el: '#app',
        data() {
            return {
                tableColumns: [
                    {
                        title: '标题',
                        key: 'title',
                        render (h,params){
                            let row = params.row;
                            let text = row.title;
                            //return h('span',text);
                            return h('a', {
                                attrs: {
                                    href:row.display_url,
                                    target: "view_window"
                                }
                            }, text);
                        }
                    },
                    {
                        title: '类型',
                        key: 'type',
                        width: 100,
                        render (h,param){
                            let text = '';
                            switch(Number(param.row.type)){
                                case 1:
                                    text = '专辑';
                                    break;
                                case 0:
                                    text = '图集';
                                    break;
                            }
                            return h('Tag',text);
                        }
                    },
                    {
                        title: '频道',
                        key: 'source',
                        width: 150,
                    },
                    {
                        title: '阅读数',
                        key: 'go_detail_count',
                        width: 130,
                    },
                    {
                        title: '评论数',
                        key: 'comments_count',
                        width: 100,
                    },
                    {
                        title: '文章发布时间',
                        key: 'behot_time',
                        width: 180,
                    }
                ],

                tableData: [],
                searchArr: {
                    article_type: 0,
                    online_time: '',
                    plate: '',
                },
                pageSize: 100,
                pageCount: 20,
                pageIndex: 1,
                amount: 0,
                tableHight: 600,
            }
        },
        methods: {
            getArticleIssueData() {
                var nowdate = new Date();
                var end_y = nowdate.getFullYear();
                var end_m = nowdate.getMonth()+1;
                var end_d = nowdate.getDate();
                vm.searchArr.online_time[1] = end_y+'-'+end_m+'-'+end_d;
                nowdate.setMonth(nowdate.getMonth()-1);
                var start_y = nowdate.getFullYear();
                var start_m = nowdate.getMonth()+1;
                var start_d = nowdate.getDate();
                vm.searchArr.online_time[0] = start_y+'-'+start_m+'-'+start_d;
                axios.get("http://tm.youdnr.com/api/temai/article/day_hotarticle", {
                    params: {
                        article_type:vm.searchArr.article_type,
                        page: 1,
                        page_count: vm.pageCount,
                        online_time_start: vm.searchArr.online_time[0],
                        online_time_end: vm.searchArr.online_time[1],
                        plate: '',
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
            //屏幕自适应
            screenAuto(){
                var Hproportion=window.screen.availHeight/900;
                vm.tableHight=vm.tableHight*Hproportion;
            },
            search() {
                // this.searchArr['title']=this.searchArr['title'].replace(/\+/g,'%2B')
                this.handleSpinCustom();
                axios.get("http://tm.youdnr.com/api/temai/article/day_hotarticle", {
                    params: {
                        article_type:vm.searchArr.article_type,
                        page: 1,
                        page_count: vm.pageCount,
                        online_time_start: vm.searchArr.online_time[0],
                        online_time_end: vm.searchArr.online_time[1],
                        plate:vm.searchArr.plate,
                    }
                })
                    .then(function (response) {
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                        vm.$Spin.hide();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            changeAtype(type){
                vm.searchArr.article_type=type;
                vm.searchArr.plate='';
                this.pageChange(1);
            },
            changePlate(plate){
                vm.searchArr.plate=plate;
                this.pageChange(1);
            },
            pageChange(index) {
                window.scrollTo(0,0); // 触发回到顶部，再加载数据
                vm.pageIndex=index;
                this.handleSpinCustom();
                axios.get("http://tm.youdnr.com/api/temai/article/day_hotarticle", {
                    params: {
                        article_type:vm.searchArr.article_type,
                        page: vm.pageIndex,
                        page_count: vm.pageCount,
                        online_time_start: vm.searchArr.online_time[0],
                        online_time_end: vm.searchArr.online_time[1],
                        plate:vm.searchArr.plate
                    }
                })
                    .then(function (response) {
                        vm.tableData = response.data.data;
                        vm.amount = response.data.total;
                        vm.$Spin.hide();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            handleSpinCustom () {
                this.$Spin.show({
                    render: (h) => {
                        return h('div', [
                            h('Icon', {
                                'class': 'demo-spin-icon-load',
                                props: {
                                    type: 'ios-loading',
                                    size: 18
                                }
                            }),
                            h('div', 'Loading')
                        ])
                    }
                });
            },
            dateValueFormat(f,v){
                this.searchArr.online_time = f;
            }
        }
    });
    vm.screenAuto();
    vm.getArticleIssueData();
</script>
{{--@stop--}}