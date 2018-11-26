<style>
    #foo{
        /*background-color: #FF2400;*/
        background-color: #2d8cf0;
        border-color: #2d8cf0;
    }
</style>
<div id="app">

    <Row type="flex" justify="center" align="middle" >
        <i-col span="23" style="margin-top: 20px;">
            <i-input v-model="searchArr.shop_id" placeholder="特卖号" style="width: 200px;"></i-input>
            <i-button type="primary" @click="search">搜索</i-button>

            <Poptip confirm title="是否重置？" @on-ok="restartAll">
            <i-button type="warning">批量重置</i-button>
            </Poptip>
            <Poptip confirm title="是否设置小店图集/专辑数？" @on-ok="resetNumAll">
            <i-button type="warning">批量设置</i-button>
            </Poptip>
            <Poptip confirm title="是否批量设置启用状态？" @on-ok="isAllStart">
            <i-button >批量启用</i-button>
            </Poptip>
            <Poptip confirm title="是否批量设置专辑分发启用状态？" @on-ok="isAllAlbums">
            <i-button >批量启用专辑</i-button>
            </Poptip>
            <Poptip confirm title="是否批量设置图集分发启用状态？" @on-ok="isAllPics">
            <i-button >批量启用图集</i-button>
            </Poptip>
        </i-col>
    </Row>
    <Row type="flex" justify="center" align="middle" >
        <i-col span="23" style="margin-top: 20px">
            <i-table height="1000" ref="selection" :data="tableData" :columns="tableColumns" stripe></i-table>
        </i-col>
    </Row>
    <Modal v-model="modal" width="400" @on-ok="ok" :closable="false" :styles="{top: '10'}">
    <i-col span="24" style="margin-top:20px;">
        <h4>ID:</h4>
        <input v-model="id"  disabled="true"  class="ivu-input ivu-input-default" />
    </i-col>
    <i-col span="24" style="margin-top:20px;">
        <h4>特卖号:</h4>
        <input v-model="name" disabled="true" class="ivu-input ivu-input-default"/>
    </i-col>
    <i-col span="24" style="margin-top:20px;">
        <h4>小店图集数:</h4>
        <input v-model="xd_pics_num"   class="ivu-input ivu-input-default"/>
    </i-col>
    <i-col span="24" style="margin-top:20px;">
        <h4>小店专辑数:</h4>
        <input v-model="xd_albums_num"   class="ivu-input ivu-input-default"/>
    </i-col>

    <br/>

    </Modal>
    <Modal v-model="resetNummodal" title="批量修改小店图集/专辑数" width="400" @on-ok="resetNumOk" :closable="false" :styles="{top: '10'}">
    <i-col  style="margin-top:20px;">
        <h4>小店图集数:</h4>
        <input v-model="xd_pics_num"   class="ivu-input ivu-input-default"/>
    </i-col>
    <i-col  style="margin-top:20px;">
        <h4>小店专辑数:</h4>
        <input v-model="xd_albums_num"   class="ivu-input ivu-input-default"/>
    </i-col>

    <br/>

    </Modal>
    <Modal v-model="IsStartModal" title="批量修改账号启用状态" width="400" @on-ok="changeAllStart" :closable="false" :styles="{top: '10'}">
    <i-col  style="margin-top:20px;">
            <h4>启用状态:</h4>
            <br/>
            <radio-group v-model="isOnStart">
                <Radio label="开"></Radio>
                <Radio label="关"></Radio>
            </radio-group>
    </i-col>
    <br/>

    </Modal>
    <Modal v-model="IsAlbumsModal" title="批量修改图集分发启用状态" width="400" @on-ok="changeAllAlbums" :closable="false" :styles="{top: '10'}">
    <i-col  style="margin-top:20px;">
        <h4>启用状态:</h4>
        <br/>
        <radio-group v-model="isOnAlbums">
            <Radio label="开"></Radio>
            <Radio label="关"></Radio>
        </radio-group>
    </i-col>
    <br/>

    </Modal>
    <Modal v-model="IsPicsModal" title="批量修改图集分发启用状态" width="400" @on-ok="changeAllPics" :closable="false" :styles="{top: '10'}">
    <i-col  style="margin-top:20px;">
        <h4>启用状态:</h4>
        <br/>
        <radio-group v-model="isOnPics">
            <Radio label="开"></Radio>
            <Radio label="关"></Radio>
        </radio-group>
    </i-col>
    <br/>

    </Modal>
    <br/>
</div>

<script>
    let vm = new Vue({
        el: '#app',
        data() {
            return {
                tableColumns: [
                    {
                        type: 'selection',
                       // width: 50,
                        align: 'center',
                        key:'id'
                        // }, {
                        //     title: '文章编号',
                        //     key: 'article_number',
                        //     width:160
                    },
                    {
                        title: 'id',
                        key: 'id',
                       // width: 80
                    },
                    {
                        title: '特卖号',
                        key: 'name',
                       // width: 150
                    },
                    {
                        title: '小店图集',
                        key: 'xd_pics_num',
                        //width: 85
                    },
                    {
                        title: '小店剩余图集',
                        key: 'xd_res_pics_num',
                      //  width: 85
                    },
                    {
                        title: '小店专辑',
                        key: 'xd_albums_num',
                        width: 85
                    },
                    {
                        title: '小店剩余专辑',
                        key: 'xd_res_albums_num',
                       // width: 85
                    },
                    {
                        title: '剩余图集',
                        key: 'res_pics_num',
                       // width: 85
                    },
                    {
                        title: '剩余专辑',
                        key: 'res_albums_num',
                      //  width: 85
                    },
                    {
                        title: '精选图集',
                        key: 'choice_pics_num',
                       // width: 85
                    },
                    {
                        title: '精选专辑',
                        key: 'choice_albums_num',
                       // width: 85
                    },
                    {
                        title: '是否启用',
                        key: 'is_start',
                       // width: 80,
                        render: (h, params) => {
                            let row = params.row;
                            let show = row.is_start == 1 ? true:false;
                            return h('i-switch', {
                                props: {
                                    size: 'large',
                                    value: show
                                },
                                on: {
                                    'on-change': (status) => {
                                        let is_start = status == true ? 1 : 0;
                                        vm.changeIsStart(row.id,is_start);
                                    }
                                }
                            }, [
                                h('span', {
                                    slot: 'open'
                                }, '是'),
                                h('span', {
                                    slot: 'close'
                                }, '否')
                            ])
                        }
                    },
                    {
                        title: '是否分发专辑',
                        key: 'is_albums',
                        //width: 80,
                        render: (h, params) => {
                            let row = params.row;
                            let show = row.is_albums == 1 ? true:false;
                            return h('i-switch', {
                                props: {
                                    size: 'large',
                                    value: show
                                },
                                on: {
                                    'on-change': (status) => {
                                        let is_albums = status == true ? 1 : 0;
                                        vm.changeIsAlbums(row.id,is_albums);
                                    }
                                }
                            }, [
                                h('span', {
                                    slot: 'open'
                                }, '是'),
                                h('span', {
                                    slot: 'close'
                                }, '否')
                            ])
                        }
                    },
                    {
                        title: '是否分发图集',
                        key: 'is_pics',
                       // width: 80,
                        render: (h, params) => {
                            let row = params.row;
                            let show = row.is_pics == 1 ? true:false;
                            return h('i-switch', {
                                props: {
                                    size: 'large',
                                    value: show
                                },
                                on: {
                                    'on-change': (status) => {
                                        let is_pics = status == true ? 1 : 0;
                                        vm.changeIsPics(row.id,is_pics);
                                    }
                                }
                            }, [
                                h('span', {
                                    slot: 'open'
                                }, '是'),
                                h('span', {
                                    slot: 'close'
                                }, '否')
                            ])
                        }
                    },

                    {
                        title: '操作',
                        key: 'action',
                       // width: 105,
                        align: 'center',
                        render: (h, params) => {
                            let row = params.row;
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            vm.editor(row)
                                        }
                                    }
                                }, '编辑')
                            ]);
                        }
                    }
                ],
                tableData: [],
                tableLoading: false,
                id:0,
                name:'',
                xd_pics_num:0,
                xd_albums_num:0,
                modal: false,
                article_id: 0,
                resetNummodal:false,
                searchArr: {
                    shop_id: '',
                },
                IsStartModal:false,
                IsAlbumsModal:false,
                IsPicsModal:false,
                isOnStart: "关",
                isOnAlbums:"关",
                isOnPics:"关",
            }
        },
        mounted() {
            this.$Message.config({top: 200,duration: 3});
        },
        methods: {
            // 表格按钮编辑事件
            editor(table_id) {
                this.modal = true;
                this.id=table_id.id;
                this.name=table_id.name;
                this.xd_pics_num=table_id.xd_pics_num;
                this.xd_albums_num=table_id.xd_albums_num;

            },
            ok() {
                //console.log('执行了');
                //alert(this.id );
                axios.get("/admin/auth/up_all_reset_num", {
                    params: {
                        shop_id: [this.id] ,
                        xd_pics_num: this.xd_pics_num,
                        xd_albums_num: this.xd_albums_num
                    }
                })
                    .then(function (response) {
                        console.log(response.data);
                        if(response.data.code=='ok'){
                            vm.$Message.success(response.data.msg);
                            vm.getTemaiListData(); //偷个懒...
                        }
//                        else{
//                            vm.$Message.error(response.data.msg);
//                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            // 表格按钮清空事件
            clear(table_id) {
                this.editor(table_id);
                this.modal = false;
                this.delPlatformPermission(this.table_datas[table_id].id, this.transfer_data_selected);
                this.transfer_data_selected = [];
            },
            // 获取特卖号列表
            getTemaiListData() {
                axios.get("/admin/auth/get_temai_list_data", {
                    params: {
                        searchArr:vm.searchArr
                    }
                })
                    .then(function (response) {
                        console.log(response)
                        vm.tableData = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            //是否启用
            changeIsStart(id,is_start){
                axios.get("/admin/auth/change_is_on", {
                    params: {
                        id: [id],
                        is_start: is_start,
                        type:'is_start'
                    }
                })
                    .then(function (response) {
                        console.log(response);
                        vm.$Message.success(response.data.msg);
                        vm.getTemaiListData(); //偷个懒...
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            //是否发布图集
            changeIsPics(id,is_pics){
                axios.get("/admin/auth/change_is_on", {
                    params: {
                        id: [id],
                        is_pics: is_pics,
                        type:'is_pics'
                    }
                })
                    .then(function (response) {
                        console.log(response);
                        vm.$Message.success(response.data.msg);
                        vm.getTemaiListData(); //偷个懒...
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            //是否发布专辑
            changeIsAlbums(id,is_albums){
                axios.get("/admin/auth/change_is_on", {
                    params: {
                        id: [id],
                        is_albums: is_albums,
                        type:'is_albums'
                    }
                })
                    .then(function (response) {
                        console.log(response);
                        vm.$Message.success(response.data.msg);
                        vm.getTemaiListData(); //偷个懒...
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            //批量重置
            restartAll(shop_id = '') {
                let that = this;
                if(shop_id === '') shop_id = this.batch();
                //alert(shop_id);
                //console.log(shop_id);
                if(shop_id==''){
                    that.$Message.error('请选择您要重置的账号！');
                }else{
                    axios.get("/admin/auth/restart_all", {
                        params: {
                            shop_id
                        }
                    }).then(response => {
                        that.$Message.success(response.data);
                        vm.getTemaiListData(); //偷个懒...
                    })
                }

            },
            //批量设置小店图集/专辑数
            resetNumAll(){
                vm.resetNummodal = true
            },
            //批量设置小店图集/专辑数
            resetNumOk(shop_id = ''){
                let that = this;
                if(shop_id === '') shop_id = this.batch();
                //alert(this.xd_pics_num);
                if(shop_id==''){
                    that.$Message.error('请选择您要设置的账号！');
                }else{
                    axios.get("/admin/auth/up_all_reset_num", {
                        params: {
                            shop_id,
                            xd_pics_num: this.xd_pics_num,
                            xd_albums_num: this.xd_albums_num
                        }
                    }).then(response => {
                        if(response.data.code=='ok'){
                            vm.$Message.success(response.data.msg);
                            vm.getTemaiListData(); //偷个懒...
                        }
                    })
                }
            },
            //批量启用
            isAllStart(){
                vm.IsStartModal = true;
            },
            changeAllStart(shop_id = ''){
                let that = this;
                if(shop_id === '') shop_id = this.batch();

                if(shop_id==''){
                    that.$Message.error('请选择您要启用的账号！');
                }else{
                    if(vm.isOnStart=="关"){
                        var is_start=0;
                    }else{
                        var is_start=1;
                    }
                    axios.get("/admin/auth/change_is_on", {
                        params: {
                            id: shop_id,
                            is_start: is_start,
                            type:'is_start'
                        }
                    })
                    .then(function (response) {
                        console.log(response);
                        vm.$Message.success(response.data.msg);
                        vm.getTemaiListData(); //偷个懒...
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            //批量启用分发专辑
            isAllAlbums(){
                vm.IsAlbumsModal = true;
            },
            changeAllAlbums(shop_id = ''){
                let that = this;
                if(shop_id === '') shop_id = this.batch();

                if(shop_id==''){
                    that.$Message.error('请选择您要启用的账号！');
                }else{
                    if(vm.isOnAlbums=="关"){
                        var is_albums=0;
                    }else{
                        var is_albums=1;
                    }
                    axios.get("/admin/auth/change_is_on", {
                        params: {
                            id: shop_id,
                            is_albums: is_albums,
                            type:'is_albums'
                        }
                    })
                        .then(function (response) {
                            console.log(response);
                            vm.$Message.success(response.data.msg);
                            vm.getTemaiListData(); //偷个懒...
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            //批量启用分发图集
            isAllPics(){
                vm.IsPicsModal = true;
            },
            changeAllPics(shop_id = ''){
                let that = this;
                if(shop_id === '') shop_id = this.batch();

                if(shop_id==''){
                    that.$Message.error('请选择您要启用的账号！');
                }else{
                    if(vm.isOnPics=="关"){
                        var is_pics=0;
                    }else{
                        var is_pics=1;
                    }
                    axios.get("/admin/auth/change_is_on", {
                        params: {
                            id: shop_id,
                            is_pics: is_pics,
                            type:'is_pics'
                        }
                    })
                        .then(function (response) {
                            console.log(response);
                            vm.$Message.success(response.data.msg);
                            vm.getTemaiListData(); //偷个懒...
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            batch() {
                let shop_ids = [];
                this.$refs.selection.getSelection().map(item => {
                    shop_ids.push(item.id);
                });
                return shop_ids;
            },
            //搜索
            search() {
                axios.get("/admin/auth/get_temai_list_data", {
                    params: {
                        searchArr: this.searchArr
                    }
                })
                    .then(function (response) {
                        vm.tableData = response.data;
                        //vm.amount = response.data.count;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        }
    });

    vm.getTemaiListData();
</script>