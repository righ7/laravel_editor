
<style>

</style>
<div id="app">
    <i-col span="6" v-for="(item,index) in godsData" style="margin-right: 20px">
        <Card :bordered="false">
            <div slot="title" style="vertical-align:center">
                <Avatar size="small" style="background-color: #87d068" icon="ios-person" ></Avatar>
                <div style="margin-left: 6px;display: inline-block;">{{ item.remark }}</div>
                <a style="float: right" @click="toArticle(item.author_temai_id)">TA的文章</a>
            </div>
            <div style="margin-bottom: 20px"><span>【简介】{{item.describe}}</span></div>
            <div><span>{{ item.creat_time }}</span><a style="float: right" @click="cancel(item.author_temai_id,index)">取消关注</a></div>
        </Card>
    </i-col>
    <back-top></back-top>
</div>

<script>

    let vm = new Vue({
        el: '#app',
        data() {
            return {
                godsData:[]
            }
        },
        methods: {
            getGods(){
                axios.get("<?php echo e(route('temai_article.get_gods_data')); ?>", {
                    params: {}
                })
                    .then(function (response) {
                        if (response.data.code==0){
                            vm.godsData=response.data.data;
                        }
                    })
                    .catch(function (error) {
                        vm.$Message.error('系统出错了！')
                    });
            },
            cancel(author,index){
                this.$Modal.confirm({
                    title: '取消关注',
                    content: '<p>确定要取消关注该大神吗？</p>',
                    onOk: () => {
                        axios.get("<?php echo e(route('temai_article.cancel_concern')); ?>", {
                            params: {
                                author:author
                            }
                        })
                            .then(function (response) {
                                if (response.data.code==0){
                                    vm.$Message.success('已取消')
                                    vm.godsData.splice(index,1)
                                }
                            })
                            .catch(function (error) {
                                vm.$Message.error('系统出错了！')
                            });
                    }
                });
            },
            toArticle(author){
                window.location.href='/admin/temai_article/temai_good_article'+'?user='+author;
            }
        }
    });
    vm.getGods();
</script>