<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                        </div>
                            <div class="box-body row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Search with text</label>
                                        <input type="text" v-model="form.search_text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <select id="religion" v-model="form.religion" class="form-control" autocomplete="off">
                                            <option value="">Select Religion</option>
                                            <option value="Muslim">Muslim</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" v-model="form.gender">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Blood Group</label>
                                        <select class="form-control" v-model="form.blood_group">
                                            <option value="">Select</option>
                                            <option value='O+'>O+</option>
                                            <option value="A+">A+</option>
                                            <option value="B+">B+</option>
                                            <option value="AB+">AB+</option>
                                            <option value="O-">O-</option>
                                            <option value="A-">A-</option>
                                            <option value="B-">B-</option>
                                            <option value="AB-">AB-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Para</label>
                                        <select class="form-control" v-model="form.para_id">
                                            <option value="">Select Para</option>
                                            <option :value="para.id" v-for="para in paras" >{{para.name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="button" @click="searchPeople" class="btn btn-primary btn-sm checkbox-toggle pull-right">
                                            <i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>

                            </div>
                    </div>

                </div>

                <div class="col-lg-12">

                    <div class="box box-primary" id="exphead">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resident List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label">Resident List</div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>Mother Name</th>
                                        <th>Number</th>
                                        <th>Para</th>
                                        <th>Gender</th>
                                        <th>Blood</th>
                                        <th class="text-right no-print" width="100px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(people, index) in peoples" :key="people.id">
                                        <td >{{index+1}}</td>
                                        <td >{{people.name}}</td>
                                        <td >
                                            <span v-if="people.father_name">{{people.father_name}}</span>
                                            <span v-else>{{people.father.name}}</span>
                                        </td>
                                        <td >
                                            <span v-if="people.mother_name">{{people.mother_name}}</span>
                                            <span v-else>{{people.mother.name}}</span>
                                        </td>
                                        <td >{{people.mobile_numbers}}</td>
                                        <td v-if="people.para">{{people.para.name}}</td>
                                        <td v-else>--</td>
                                        <td >{{people.gender}}</td>
                                        <td >{{people.blood_group}}</td>
                                        <td class="text-right">
                                            <router-link :to="{name:'showPeople', params:{id:people.id}}" class="btn btn-success btn-xs" data-toggle="tooltip" title="View Profile">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            <router-link :to="{name:'editPeople', params:{id:people.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Profile">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button @click="deletePeople(people.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" >
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
        name: "ViewPeople",
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
            this.allPeople();
        },
        watch: {
            peoples(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $('#dataTable').DataTable()
                });
            }
        },
        data(){
            return{
                paras:[],
                peoples:[],
                form:{
                    religion:'',
                    gender:'',
                    search_text:'',
                    blood_group:'',
                    para_id:'',
                },
                errors:{}
            }
        },

        methods:{
            allPara() {
                axios.get('/api/para'+'?villageId='+User.villageId())
                    .then(({data}) => (this.paras = data))
                    .catch()
            },
            searchPeople(){
                var queryString = {
                    villageId:User.villageId(),
                    search_text:this.form.search_text,
                    gender:this.form.gender,religion:this.form.religion,
                    blood_group:String(this.form.blood_group),
                    para_id:String(this.form.para_id)
                }
                axios.get('/api/people',{params:queryString})
                    .then(({data})=>this.peoples = data)
                    .catch(error=>{
                        this.errors = error.response.data.errors
                    })
            },
            allPeople(){
                var village_id = User.villageId();
                axios.get('/api/people'+'?villageId='+village_id)
                    .then(({data})=>this.peoples = data)
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
                        axios.delete('/api/people/'+id)
                            .then(() =>{
                                this.peoples = this.peoples.filter(people=>{
                                    return people.id != id

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