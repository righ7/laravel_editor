<script>
    // 添加商品到分组组件
    let addGoodsGroup = {
        template: `
            <span>
                <Poptip width="200" style="margin-left: 20px;">
                    <i-button type="primary">添加到分组</i-button>
                    <div slot="content">
                        <button-group vertical style="width: 100%">
                            <i-button v-for="group in goodsGroup" @click="goodsAddToGroup(group)" :key="group.id">@{{ group.name }} ( @{{ group.goods_amount }} )</i-button>
                            <i-button type="info" @click="tabChange(4)">商品分组管理</i-button>
                        </button-group>
                    </div>
                </Poptip>
            </span>
        `,
        methods: {
            goodsAddToGroup(group){
                let that = this;
                let group_id = group.id; // 分组ID
                let goods_id_arr = [];   // 已选商品

                that.goodsSelect.map(item => {
                    goods_id_arr.push(item.goods_id);
                });

                if(goods_id_arr.length < 1){
                    that.$Message.info('请选择商品');
                    return false;
                }

                axios.get("{{ route('goods_group/curd_goods_group_detail') }}",{
                    params:{
                        curd: 1,
                        goods_id_arr : goods_id_arr,
                        goods_group_id: group_id,
                    }
                }).then(function (r) {
                    if(r.data.indexOf('请选择商品') != -1){
                        that.$Message.info(r.data);
                    }else if(r.data.indexOf('添加商品成功') != -1){
                        that.$Message.success(r.data);
                        bus.$emit('getGoodsGroup');
                    }
                });
            },
            tabChange(index){
                bus.$emit('tabChange',index);
            },
        },
        computed:{
            goodsGroup() {
                return this.$store.state.goodsGroup;
            },
            goodsSelect() {
                return this.$store.state.goodsSelect;
            }
        }
    }

    // 商品分组组件
    let goodsGroup = {
        template: `
            <div>
                <div :style="{ display: goods_group_display == true ? 'block':'none' }">
                    <div @click="createGoodsGroup" style="cursor: pointer; width: 250px; height: 120px; float: left; margin: 8px;">
                        <Card style="width: 250px; height: 120px;">
                            <Icon type="md-add" style="font-size: 50px; position: relative; left: 80px;top:15px;" />
                        </Card>
                    </div>
                    <div v-for="(group,index) in goods_group" :key="group.id" style="width: 250px;height:120px;float: left; margin:8px;">
                        <Card style="width: 250px; height: 120px;">
                            <p slot="title">@{{ group.name }}</p>
                            <div slot="extra" style="cursor: pointer;">
                                <Tooltip placement="top" content="排序">
                                    <InputNumber @on-blur="groupOrder(group)" v-model="group.order_num" :disabled="group.is_disable == 1 ? true : false" size="small" style="width: 52px;"></InputNumber>
                                </Tooltip>
                                <Tooltip placement="top" content="状态">
                                    <Select @on-change="gruopPermissionChange($event,group)" :disabled="group.is_disable == 1 ? true : false" v-model="group.permission" size="small" style="width:60px">
                                        <Option value="0" key="0">私有</Option>
                                        <Option value="1" key="1">公开</Option>
                                    </Select>
                                </Tooltip>
                                <Tooltip placement="top" content="删除">
                                    <Icon @click.stop="deleteGoodsGroup(group)" :style="{ display: group.is_disable == 1 ? 'none' : 'inline' }" style="font-size: 20px; margin-left: 5px;" type="md-trash" />
                                </Tooltip>
                            </div>
                            <div>
                                <Button @click="showGoodsGroupDetail(group)" type="primary">查看商品 ：@{{ group.goods_amount }}</Button>
                            </div>
                        </Card>
                    </div>
                </div>
                <div :style="{ display: goods_group_display == true ? 'none':'block' }">
                    <Button @click="hideGoodsGroupDetail">返回</Button>
                    <Button @click="deleteGoodsGroupDetail" :style="{display: current_goods_group.is_disable == 1 ? 'none':'inline'}" type="warning">批量删除</Button>
                    <div>
                        <Row type="flex" justify="center">
                            <Col v-for="(goods, index) in goodsData" :key="goods.id" :class="[ goods.status === true ? 'goods-select':'' ]" class="card" :xs="10" :sm="8" :md="6" :lg="4">
                                <div @click="goodsActive(index)">
                                    <div class="card-content" style="width: 165px;margin: 10px auto;">
                                        <div style="position: relative;">
                                            <div v-if="goods.is_recommend == 1" class="card-recommend">推荐</div>
                                            <img width="165" height="165" :src="goods.image">
                                            <div>
                                                <div class="card-url"><a :href="goods.goods_url" target="_blank">@{{ goods.title }}</a></div>
                                                <div>
                                                    <span style="color: red; font-size: 16px;">￥@{{ goods.price }}</span>
                                                    <span style="color: red;">佣金</span> <span style="color:red; font-size:15px;">@{{ commission_earnings(goods.commission_rate, goods.price) }} (@{{ commission_rate(goods.commission_rate) }})</span>
                                                </div>
                                                <div>
                                                    销量：@{{ goods.sell_num }}
                                                    <span style="margin-left: 6px;">热度：@{{ goods.goods_heat }}</span>
                                                </div>
                                                <div class="card-shop">
                                                    <a :href="['https://haohuo.snssdk.com/views/shop/index?id='+goods.shop_id]" target="_blank">@{{ goods.shop_name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Col>
                        </Row>
                    </div>
                    <Row type="flex" justify="center">
                        <Col>
                            <Page :total="page.total" :current="page.current" :page-size="page.pageSize" @on-change="pageCurrentChange" show-elevator show-total/>
                        </Col>
                    </Row>
                </div>
            </div>
        `,
        data() {
            return {
                goods_group_display: true,
                current_goods_group: [], // 当前操作的 group,
                goodsData: [],
                page: {
                    total:0,
                    current: 1,
                    pageSize: 78
                },
            }
        },
        computed:{
            goods_group() {
                return this.$store.state.goodsGroup;
            },
            goodsSelect() {
                return this.$store.state.goodsSelect;
            }
        },
        methods: {
            createGoodsGroup() { // 创建分组
                let goods_group_name = '';
                let that = this;
                that.$Modal.confirm({
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: goods_group_name,
                                autofocus: true,
                                placeholder: '请输入分组名'
                            },
                            on: {
                                input: (val) => {
                                    goods_group_name = val;
                                }
                            }
                        })
                    },
                    onOk: function(){
                        if(goods_group_name.trim().length < 1 ){
                            that.$Message.info('未输入分组名');
                            return false;
                        }
                        axios.get('{{ route('goods_group/curd_goods_group') }}',{
                            params:{
                                'curd': 1,
                                'goods_group_name': goods_group_name,
                            }
                        }).then((r)=>{
                            that.$store.commit('getGoodsGroup');
                            that.$Message.success('创建成功');
                        })
                    }
                })
            },
            hideGoodsGroupDetail() { // 隐藏分组商品
                let that = this;
                that.goods_group_display = true;
                that.$store.commit('getGoodsGroup');
            },
            deleteGoodsGroupDetail() { // 批量删除分组内商品
                let that = this;
                let group_id = that.current_goods_group.id;
                let goods_id_arr = [];
                that.goodsSelect.map((item) => {
                    goods_id_arr.push(item.goods_id);
                });
                if(goods_id_arr.length < 1){
                    that.$Message.info('未选中商品');
                }
                axios.get('{{ route('goods_group/curd_goods_group_detail') }}', {
                    params: {
                        curd:2,
                        goods_id_arr: goods_id_arr,
                        goods_group_id: group_id
                    }
                }).then(function (r) {
                    that.$Message.success('删除成功');
                    that.getGoodsGroupDetail(r.data);
                    that.$store.commit('delAllGoodsSelect');
                });
            },
            deleteGoodsGroup(group) { // 删除分组
                let that = this;
                if(Number(group.goods_amount) > 0){ // 分组内有商品
                    let delVerify = '';
                    that.$Modal.confirm({
                        title: '删除商品及对应的分组，请输入“删除”执行',
                        render: (h) => {
                            return h('Input', {
                                props: {
                                    value: delVerify,
                                    autofocus: true,
                                    placeholder: ''
                                },
                                on: {
                                    input: (val) => {
                                        delVerify = val;
                                    }
                                }
                            })
                        },
                        onOk: function(){
                            if(delVerify === '删除'){
                                axios.get('{{ route('goods_group/curd_goods_group') }}',{
                                    params:{
                                        curd:2,
                                        id: group.id
                                    }
                                }).then((r)=>{
                                    that.$store.commit('getGoodsGroup');
                                    that.$Message.success(r.data);
                                }).catch((e)=>{
                                    console.log(e);
                                })
                            } else {
                                that.$Message.info('无操作');
                            }
                        }
                    })
                }else{ // 无商品
                    axios.get('{{ route('goods_group/curd_goods_group') }}',{
                        params:{
                            curd:2,
                            id: group.id
                        }
                    }).then((r)=>{
                        that.$store.commit('getGoodsGroup');
                        that.$Message.success(r.data);
                    })
                }
            },
            showGoodsGroupDetail(group) { // 显示分组商品
                let that = this;
                that.goods_group_display = false;
                that.current_goods_group = group;
                that.page.total = group.goods_amount;
                that.getGoodsGroupDetail(group.goods_id_arr);
            },
            getGoodsGroupDetail(goods_id_arr) { // 公共库请求收藏商品数据
                let that = this;
                let url = that.$store.state.commonUrlV2;
                that.$Spin.show();
                axios.get(url, {
                    params: {
                        page: 1,
                        limit: 78,
                        goods_id_arr: goods_id_arr
                    }
                }).then(function (response) {
                    that.goodsData = response.data.data;
                }).finally(()=>{
                    that.$Spin.hide();
                });
            },
            goodsActive(index) { // 选中商品事件
                let that = this;
                if(that.goodsData[index].status === true){
                    that.goodsData[index].status = false;
                    that.goodsSelect.map((obj, key)=>{
                        if(obj.id === that.goodsData[index].id){
                            that.$store.commit('delGoodsSelect',key);
                        }
                    });
                }else{
                    let is_exist = false; // 查找是否有同样记录
                    that.goodsSelect.map((obj, key)=>{
                        if(obj.id === that.goodsData[index].id){
                            is_exist = true;
                        }
                    });

                    if(is_exist) this.$Message.info('商品已经勾选');
                    if(!is_exist){
                        that.goodsData[index].status = true;
                        that.$store.commit('addGoodsSelect',this.goodsData[index]);
                    }
                }
            },
            pageCurrentChange(index) { // 分组分页
                let that = this;
                axios.get('{{ route('goods_group/get_goods_group_detail') }}',{
                    params:{
                        limit: that.page.limit,
                        page_index: index,
                        group_id: that.current_goods_group.id
                    }
                }).then(r => {
                    that.getGoodsGroupDetail(r.data);
                })
            },
            commission_rate (value) {
                return this.$store.getters.commission_rate(value);
            },
            commission_earnings (value, price) {
                return this.$store.getters.commission_earnings(value, price);
            }
        }
    }
</script>