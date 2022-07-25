<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Para</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Para Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Para Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.para_id == ''" type="submit" @click.prevent="addPara" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updatePara" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Para List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Para List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Para Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="para in paras" :key="para.id">
                                        <td class="mailbox-name">{{para.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editPara(para)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deletePara(para.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    </tbody>
                                </table><!-- /.table -->
                            </div><!-- /.mail-box-messages -->
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Para",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
               this.$router.back();
            }
        },

        mounted(){
            this.dt = $('#dataTable').DataTable();
             this.allPara();
             this.resetData();

        },
        watch: {
            paras(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                paras:[],
                form:{
                    name: null,
                    para_id: '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },

        methods:{
            allPara(){
                axios.get('/api/para'+'?villageId='+User.villageId())
                    .then(({data}) => (this.paras = data))
                    .catch()
            },

            addPara(){
                let _this = this;
                axios.post('/api/para',this.form)

                    .then(res => {
                        toastr.success('Para Add Successfully', {timeOut: 500});
                        _this.allPara();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updatePara(){
                let id = this.form.para_id;
                let _this = this;
                axios.patch('/api/para/'+id,this.form)
                    .then(res=>{
                        toastr.success('Para Update Successfully', {timeOut: 500});
                        _this.allPara();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editPara: function(para){
                this.form.name = para.name;
                this.form.para_id = para.id;
            },
            resetData(){
                this.form.name = '';
                this.form.para_id = '';
                this.errors=''
            },
            deletePara(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let _this = this;
                        axios.delete('/api/para/'+id)
                            .then(() =>{
                                this.paras = this.paras.filter(para=>{
                                    return para.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allPara();
                            })

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }

        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
</style>