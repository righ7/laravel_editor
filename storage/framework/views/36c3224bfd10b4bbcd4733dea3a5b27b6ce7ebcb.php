
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
    @keyframes  ani-demo-spin {
        from { transform: rotate(0deg);}
        50%  { transform: rotate(180deg);}
        to   { transform: rotate(360deg);}
    }
    .rank_first{
        width:60px;
        height: 60px;
        margin:6px 0;
    }
    .rank{
        width:50px;
        height: 50px;
        margin:6px 0;
    }
    a{
        color:#2d8cf0;
    }
    a:hover{
        color:#42A5F5;
        background: none;
    }
</style>
<div id="app">
    <div style="margin-left: 35px">
        <Tooltip content="返回">
            <i-button @click="back">
                <Icon type="ios-undo" size="19"/>
            </i-button>
        </Tooltip>
        <i-select v-model="date_swicth" @on-change="changeDateSwitch" style="width:200px">
            <i-option v-for="item in dateList" :value="item.value" :key="item.value">{{ item.label }}</i-option>
        </i-select>
    </div>
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
    <Modal
            v-model="followModal"
            title="关注大神"
            loading=true
            @on-ok="">
        <i-form ref="formCustom" :model="formCustom" :rules="ruleCustom" :label-width="80">
            <form-item label="备注" prop="name">
                <i-input type="text" placeholder="给大神起个备注吧!(3-20字)" v-model="formCustom.name"></i-input>
            </form-item>
            <form-item label="大神描述" prop="describe">
                <i-input type="textarea" :rows="4" placeholder="添加描述，不会容易忘记哦!(10-100字)" v-model="formCustom.describe"></i-input>
            </form-item>
        </i-form>
        <div slot="footer">
            <i-button type="text" size="large" @click="followModal=false">取消</i-button>
            <i-button type="primary" size="large" @click="handleSubmit('formCustom')">关注大神</i-button>
        </div>
    </Modal>
    <back-top></back-top>
</div>

<script>

    let vm = new Vue({
        el: '#app',
        data() {
            const validateName = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请填写备注'));
                } else if(value.length <3 || value.length >20){
                    callback(new Error('备注为3-20个字'));
                } else {
                    callback();
                }
            };
            const validateDescribe = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请填写描述'));
                } else if(value.length <10 || value.length >100){
                    callback(new Error('描述为10-100个字'));
                } else {
                    callback();
                }
            };
            return {
                tableColumns: [
                    {
                        title: '排名',
                        width: 130,
                        // type: 'index',
                        align: 'center',
                        render (h,param){
                            let index=(param.index+1)+(vm.pageCount*(vm.pageIndex-1)),img,class_mark;
                            if (index<4){
                                if (index==1){
                                    img="<?php echo e(asset('images/rank_01.png')); ?>";
                                    class_mark="rank_first";
                                } else if (index==2){
                                    img="<?php echo e(asset('images/rank_02.png')); ?>"
                                    class_mark="rank";
                                } else{
                                    img="<?php echo e(asset('images/rank_03.png')); ?>"
                                    class_mark="rank";
                                }
                                return h('img',{
                                    attrs: {
                                        src:img,
                                        class:class_mark
                                    },
                                });
                            } else {
                                return h('span',{
                                    attrs: {
                                        href:""
                                    }
                                },index);
                            }

                        }
                    },
                    {
                        title: '阅读数',
                        key: 'detail_sum',
                        width: 130,
                    },
                    {
                        title: '操作',
                        width: 180,
                        render (h,param){
                            return h('Dropdown',
                                {
                                    nativeOn: {
                                        click: function(){
                                            vm.formCustom.name='';
                                            vm.formCustom.describe='';
                                            vm.select_author=param.row.create_user_id;
                                            vm.concerdCheck();
                                        }
                                    }
                                },
                                [
                                    h('a',{
                                        attrs: {
                                            href:"javascript:void(0)"
                                        },
                                        on: {
                                            click: function(event){
                                                event.stopPropagation();
                                                window.location.href="/admin/temai_article/temai_good_article?user="+param.row.create_user_id;
                                            }
                                        }
                                    },'查看该作者的文章'),
                                    h('DropdownMenu',{
                                            slot: 'list',
                                        },
                                        [
                                            h('DropdownItem', '关注TA'),
                                        ]),
                                ]);
                        }
                    },
                ],
                dateList: [
                    {
                        value: 1,
                        label: '昨日排行'
                    },
                    {
                        value: 0,
                        label: '今日排行'
                    },
                    {
                        value: 7,
                        label: '近7天排行'
                    },
                    {
                        value: 30,
                        label: '近30天排行'
                    },
                ],
                date_swicth:7,
                tableData: [],
                pageSize: 100,
                pageCount: 50,
                pageIndex: 1,
                amount: 0,
                tableHight: 600,
                select_author:'',
                formCustom: {
                    name: '',
                    describe: '',
                },
                ruleCustom: {
                    name: [
                        { validator: validateName, trigger: 'change',required: true }
                    ],
                    describe: [
                        { validator: validateDescribe, trigger: 'change',required: true }
                    ],
                },
                followModal:false,
            }
        },
        methods: {
            getArticleIssueData() {
                axios.get("<?php echo e(route('temai_article.author_data')); ?>", {
                    params: {
                        page: 1,
                        page_count: vm.pageCount,
                        date_swicth:vm.date_swicth,
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
                this.handleSpinCustom();
                axios.get("<?php echo e(route('temai_article.author_data')); ?>", {
                    params: {
                        page: 1,
                        page_count: vm.pageCount,
                        date_swicth:vm.date_swicth,
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
            pageChange(index) {
                window.scrollTo(0,0); // 触发回到顶部，再加载数据
                vm.pageIndex=index;
                this.handleSpinCustom();
                axios.get("<?php echo e(route('temai_article.author_data')); ?>", {
                    params: {
                        page: vm.pageIndex,
                        page_count: vm.pageCount,
                        date_swicth:vm.date_swicth,
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
            concerdCheck(){
                axios.get("<?php echo e(route('temai_article.check_concerned')); ?>", {
                    params: {
                        author_id:vm.select_author,
                    }
                })
                    .then(function (response) {
                        if (response.data.code==0){
                            vm.followModal=true;
                        }else if(response.data.code==1){
                            vm.$Message.success('您已关注过该大神')
                        }else {
                            vm.$Message.error('系统出错了！')
                        }
                    })
                    .catch(function (error) {
                        vm.$Message.error('系统出错了！')
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
            handleSubmit(name){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        axios.get("<?php echo e(route('temai_article.concern_god')); ?>", {
                            params: {
                                name: vm.formCustom.name,
                                describe: vm.formCustom.describe,
                                author_id:vm.select_author,
                            }
                        })
                            .then(function (response) {
                                if (response.data.code==0){
                                    vm.$Message.success('已关注该大神！')
                                    vm.followModal=false;
                                }else {
                                    vm.$Message.success('系统出错了！')
                                }
                            })
                            .catch(function (error) {
                                vm.$Message.error('系统出错了！')
                            });
                    }
                })
            },
            changeDateSwitch(){
                vm.pageIndex=1;
                this.search()
            },
            back(){
                window.location.href="<?php echo e('/admin/temai_article/temai_good_article'); ?>";
            },
            dateValueFormat(f,v){
                this.searchArr.online_time = f;
            }
        }
    });
    vm.screenAuto();
    vm.getArticleIssueData();
</script>