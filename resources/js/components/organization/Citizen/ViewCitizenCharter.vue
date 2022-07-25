<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Citizen Charter List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Citizen Charter List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th width="5%">SL</th>
                                        <th width="25%">Title</th>
                                        <th width="60%">Details</th>
                                        <!--<th>Division</th>-->
                                        <!--<th>District</th>-->
                                        <!--<th>Upozilla</th>-->
                                        <!--<th>Union</th>-->
                                        <th class="text-right no-print" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(citizen, index) in citizenCharters" :key="citizen.id">
                                        <td >{{index+1}}</td>
                                        <td >{{citizen.title}}</td>
                                        <td >{{citizen.details}}</td>
                                        <!--<td >{{citizen.division_id }}</td>-->
                                        <!--<td >{{citizen.district_id }}</td>-->
                                        <!--<td >{{citizen.upozilla_id }}</td>-->
                                        <!--<td >{{citizen.union_id }}</td>-->


                                        <td class="text-right">
                                            <router-link :to="{name:'editCitizenCharter', params:{id:citizen.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Profile">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button @click="deletePeople(citizen.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "ViewCitizenCharter",
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
            this.allCitizen();
        },
        watch: {
            citizenCharters(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },
        data(){
            return{
                citizenCharters:[],
                errors:{}
            }
        },

        methods:{
            allCitizen(){
                var village_id = User.villageId();
                axios.get('/api/citizen-charter'+'?villageId='+village_id)
                    .then(({data})=>this.citizenCharters = data)
                    .catch(error=>{
                        this.errors = error.response.data.errors
                    })
            },
            deletePeople(id){
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
                        axios.delete('/api/citizen-charter/'+id)
                            .then(() =>{
                                this.citizenCharters = this.citizenCharters.filter(citizenCharter=>{
                                    return citizenCharter.id != id

                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch((error) =>{
                                var massage = this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Can Not Delete It!'
                                })
                            })


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