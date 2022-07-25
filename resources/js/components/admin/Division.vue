<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Division</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form >
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Division Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" v-model="form.name"  placeholder="Division Name" type="text" class="form-control" autocomplete="off">
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>
                                <button v-if="form.division_id == ''" type="submit" @click.prevent="addDivision" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateDivision" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Division List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Division List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-right no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="division in divisions" :key="division.id">
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover" >
                                                    {{division.name}}
                                                </a>
                                            </td>
                                            <td class="mailbox-date pull-right no-print">

                                                <button @click="editDivision(division)" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button @click="deleteDivision(division.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "division",
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
            this.allDivision();
            this.resetData();
        },
        watch: {
            divisions(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },

        data(){
            return{
                divisions:[],
                form:{
                    name: null,
                    division_id:''
                },
                errors:{}
            }
        },

        methods:{
            allDivision(){
                axios.get('/api/division')
                    .then(({data}) => (this.divisions = data))
                    .catch()
            },
            addDivision(){
                let _this = this;
                axios.post('/api/division',this.form)

                    .then(res => {
                        toastr.success('Division Add Successfully', {timeOut: 500});
                        _this.allDivision();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            updateDivision(){
                let id = this.form.division_id;
                let _this = this;
                axios.patch('/api/division/'+id,this.form)
                    .then(res=>{
                        toastr.success('Division Update Successfully', {timeOut: 500});
                        _this.allDivision();
                        this.resetData();
                    })
                    .catch(error => {
                        _this.errors = error.response.data.errors

                    })
            },
            formReset(){
                this.resetData();
            },
            editDivision: function(division){
                this.form.division_id = division.id;
                this.form.name = division.name;
            },
            resetData(){
                this.form.name = '';
                this.form.division_id = '';
                this.errors=''
            },
            deleteDivision(id){
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
                        axios.delete('/api/division/'+id)
                            .then(() =>{
                                this.divisions = this.divisions.filter(division=>{
                                    return division.id != id
                                })
                            })
                            .catch(() =>{
                                _this.allDivision();
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