<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Union</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="UpozillaName">Upozilla Name</label><small class="req"> *</small>
                                    <select v-model="form.upozilla_id" autofocus="" id="UpozillaName" class="form-control" >
                                        <option value="">Select Upozilla</option>
                                        <option :value="upizilla.id" v-for="upizilla in upizillas">{{upizilla.name}}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.upozilla_id">{{errors.upozilla_id[0]}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">Union Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Union Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.union_id == ''" type="submit" @click.prevent="addUnion" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateUnion" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Union List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Union List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Union Name</th>
                                        <th>District Name</th>
                                        <th class="text-right no-print">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="union in unions" :key="union.id">
                                        <td class="mailbox-name">{{union.name}}</td>
                                        <td class="mailbox-name" v-if="union.upozilla">{{union.upozilla.name}}</td>
                                        <td class="mailbox-date pull-right no-print">
                                            <button @click="editUnion(union)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button @click="deleteUnion(union.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "Union",
        created(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "system") {
                this.$router.push({name:'dashboard'})
            }
        },

        mounted(){
            this.dt = $('#dataTable').DataTable();
            this.allDistrict();
            this.allUnion();
            this.resetData();

        },
        watch: {
            unions(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                unions:[],
                upizillas:[],
                form:{
                    name: null,
                    upozilla_id:'',
                    union_id: ''
                },
                errors:{}
            }
        },

        methods:{
            allUnion(){
                axios.get('/api/union')
                    .then(({data}) => (this.unions = data))
                    .catch()
            },
            allDistrict(){
                axios.get('/api/upozilla')
                    .then(({data}) => (this.upizillas = data))
                    .catch()
            },
            addUnion(){
                let _this = this;
                axios.post('/api/union',this.form)

                    .then(res => {
                        toastr.success('Union Add Successfully', {timeOut: 500});
                        _this.allUnion();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateUnion(){
                let id = this.form.union_id;
                let _this = this;
                axios.patch('/api/union/'+id,this.form)
                    .then(res=>{
                        toastr.success('Union Update Successfully', {timeOut: 500});
                        _this.allUnion();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editUnion: function(union){
                this.form.union_id = union.id;
                this.form.name = union.name;
                this.form.upozilla_id = union.upozilla_id;
            },
            resetData(){
                this.form.name = '';
                this.form.upozilla_id='';
                this.form.union_id = '';
                this.errors=''
            },
            deleteUnion(id){
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
                        axios.delete('/api/union/'+id)
                            .then(() =>{
                                this.unions = this.unions.filter(union=>{
                                    return union.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allUnion();
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