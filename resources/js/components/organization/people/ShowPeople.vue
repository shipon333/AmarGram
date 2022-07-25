<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" :src="imageLink(people.avatar,people.gender)" alt="User profile picture">
                            <h3 class="profile-username text-center">{{people.name}}</h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item education_point btn-warning">
                                    <b>Education Point</b> <a class="pull-right text-aqua">{{people.point}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Unique ID</b> <a class="pull-right text-aqua">{{people.unique_id}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>NID</b> <a class="pull-right text-aqua">{{people.nid}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Passport</b> <a class="pull-right text-aqua">{{people.passport_no != null ? people.passport_no:'NA'}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Driving License</b> <a class="pull-right text-aqua">{{people.driving_license  != null ? people.driving_license :'NA'}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Gender</b> <a class="pull-right text-aqua">{{people.gender}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Blood Group</b> <a class="pull-right text-aqua">{{people.blood_group}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Age</b> <a class="pull-right text-aqua">{{getAge(people.dob)}} Years</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Mobile</b> <a class="pull-right text-aqua">{{people.mobile_numbers}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Email</b> <a class="pull-right text-aqua">{{people.email}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Height</b> <a class="pull-right text-aqua">{{people.height}}</a>
                                </li>
                                <li class="list-group-item listnoback">
                                    <b>Weight</b> <a class="pull-right text-aqua">{{people.weight}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Profile</a></li>
                            <li class=""><a href="#education_history" data-toggle="tab" aria-expanded="false">Educational History</a></li>
                            <li class=""><a href="#medical_history" data-toggle="tab" aria-expanded="false">Medical History</a></li>
                            <li class=""><a href="#achievement" data-toggle="tab" aria-expanded="false">Achievement</a></li>
                            <li class=""><a href="#donation" data-toggle="tab" aria-expanded="false">Donation</a></li>
                            <li class="pull-right"><a href="#"  class="green" data-toggle="tooltip" title="Enable"><i class="fa fa-thumbs-o-up"></i></a></li>
                            <li class="pull-right"><a href="#"  class="text-red" data-toggle="tooltip" title="Disable"><i class="fa fa-thumbs-o-down"></i></a></li>
                            <li class="pull-right"><a href="#" class="schedule_modal text-green" data-toggle="tooltip" title="Login Details"><i class="fa fa-key"></i></a></li>
                            <li class="pull-right"><a href="#" class="" data-toggle="tooltip" title="Edit Profile"><i class="fa fa-pencil"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity">
                                <div class="tshadow mb25 bozero">
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-hover table-striped tmb0">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-4">Father Name</td>
                                                <td class="col-md-5">
                                                    <button class="badge badge-success" v-if="people.father_id" @click.prevent="getFather(people.father_id)">{{ father.name }}</button>
                                                    <span v-else>{{ father.name }}</span>
                                                </td>
                                                <td rowspan="3"><img class="profile-user-img img-responsive img-circle" :src="imageLink(father.avatar,'male')"></td>
                                            </tr>
                                            <tr>
                                                <td>Father Phone</td>
                                                <td>{{ father.mobile_numbers }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father Occupation</td>
                                                <td>{{ father.profession }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mother Name</td>
                                                <td>
                                                    <button class="badge badge-success" v-if="people.mother_id" @click.prevent="getMother(people.mother_id)">{{ mother.name }}</button>
                                                    <span v-else>{{ mother.name }}</span>
                                                </td>
                                                <td rowspan="3"><img class="profile-user-img img-responsive img-circle" :src="imageLink(mother.avatar,'female')"></td>
                                            </tr>
                                            <tr>
                                                <td>Mother Phone</td>
                                                <td>{{ mother.mobile_numbers }}</td>

                                            </tr>
                                            <tr>
                                                <td>Mother Occupation</td>
                                                <td>{{ mother.profession }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tshadow mb25 bozero">
                                    <h3 class="pagetitleh2">Address </h3>
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-hover table-striped tmb0"><tbody>
                                        <tr>
                                            <td>Current Address</td>
                                            <td v-if="people.village">{{people.village.name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Para</td>
                                            <td v-if="people.para">{{people.para.name}}</td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tshadow mb25  bozero">
                                    <h3 class="pagetitleh2">Miscellaneous Details</h3>
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-hover table-striped tmb0">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-4">Date Of Birth</td>
                                                <td class="col-md-5">{{dateFormat(people.dob)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">Date Of Marriage</td>
                                                <td class="col-md-5">{{dateFormat(people.dom)}}</td>
                                            </tr>
                                            <tr v-if="people.dod">
                                                <td class="col-md-4">Date Of Die</td>
                                                <td class="col-md-5">{{dateFormat(people.dod)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">Profession</td>
                                                <td class="col-md-5">{{people.profession}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">Marital Status</td>
                                                <td class="col-md-5">{{people.marital_status}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">Spouse Name</td>
                                                <td class="col-md-5">
                                                    <span v-if="people.spouse">
                                                        {{people.spouse.name}}
                                                    </span>
                                                    <span v-else>{{people.spouse_name}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">Spouse Address</td>
                                                <td class="col-md-5">{{people.spouse_address}}</td>
                                            </tr>
                                            <tr>
                                                <td>Dependent On </td>
                                                <td>{{people.dependent_on }}</td>
                                            </tr>
                                            <tr>
                                                <td>Old Age Allowance</td>
                                                <td>
                                                    <span v-if="people.old_age_allowance == 1">Yes</span>
                                                    <span v-else>No</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Is Freedom Fighter</td>
                                                <td>
                                                    <span v-if="people.is_freedom_fighter == 1">Yes</span>
                                                    <span v-else>No</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Freedom Fighter Allowance</td>
                                                <td>
                                                    <span v-if="people.freedom_fighter_allowance== 1">Yes</span>
                                                    <span v-else>No</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Is Disabled</td>
                                                <td>
                                                    <span v-if="people.is_disabled== 1">Yes</span>
                                                    <span v-else>No</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Disability Allowance</td>
                                                <td>
                                                    <span v-if="people.disability_allowance== 1">Yes</span>
                                                    <span v-else>No</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="education_history">
                                <button type="button" @click="resetData" class="btn btn-xs btn-primary myTransportFeeBtn" data-toggle="modal" data-target="#educational_history">
                                <i class="fa fa-upload"></i>Add Education History</button>
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped tmb0">

                                        <thead>
                                            <tr>
                                                <th>Degree</th>
                                                <th>Note</th>
                                                <th>Certificate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="education_historie in education_histories">
                                                <td>{{education_historie.education_type.name}}</td>
                                                <td>{{education_historie.note}}</td>
                                                <td>
                                                    <img v-if="education_historie.files !=null" :src="oldCertificate(education_historie.files)" alt="" width="120px" height="50px">

                                                </td>
                                                <td>
                                                    <!--<button @click="editEducationHistorie(education_historie)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#educational_history" title="Edit Educational History">-->
                                                        <!--<i class="fa fa-pencil"></i>-->
                                                    <!--</button>-->
                                                    <button @click="deleteEducationHistory(education_historie.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Education History" >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="medical_history">
                                <button type="button" class="btn btn-xs btn-primary myTransportFeeBtn" data-toggle="modal" data-target="#history_of_medical">
                                    <i class="fa fa-upload"></i>Add Medical History</button>

                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped tmb0">

                                        <thead>
                                        <tr>
                                            <th>Disease Name</th>
                                            <th>Identify Date</th>
                                            <th>Cure Date</th>
                                            <th>note</th>
                                            <th>Files</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="medical_historie in history_of_medicals">
                                            <td>{{medical_historie.disease_name}}</td>
                                            <td>{{medical_historie.identify_date}}</td>
                                            <td>{{medical_historie.cure_date}}</td>
                                            <td>{{medical_historie.note}}</td>
                                            <td>file</td>
                                            <td>
                                                <button @click="editMedicalHistorie(medical_historie)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#history_of_medical" title="Edit Educational History">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button @click="deleteMedicalHistory(medical_historie.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Education History" >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="achievement">
                                <button type="button" class="btn btn-xs btn-primary myTransportFeeBtn" data-toggle="modal" data-target="#achievement_history">
                                    <i class="fa fa-upload"></i>Add Achievement History</button>
                                <div class="table-responsive around10 pt0">
                                    <table class="table table-hover table-striped tmb0">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Cirtificate</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="achievement in achievements">
                                            <td>{{achievement.title}}</td>
                                            <td>{{achievement.details}}</td>
                                            <td>{{achievement.file}}</td>
                                            <td>
                                                <button @click="editAchievementHistorie(achievement)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#achievement_history" title="Edit Educational History">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button @click="deleteAchievement(achievement.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Education History" >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="donation">
                                <div class="tshadow mb25 bozero">
                                    <div class="table-responsive around10 pt0">
                                        <table class="table table-striped table-bordered table-hover example" id="dataTable">
                                            <thead>
                                            <tr>
                                                <th>Donation Date</th>
                                                <th>Project</th>
                                                <th>Amount</th>
                                                <th>Note</th>
                                                <th class="text-right no-print">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="donation in people.donations" :key="donation.id">
                                                <td>{{ donation.donation_date }}</td>
                                                <td v-if="donation.project_id != ''">
                                                    <router-link :to="{name:'viewProject', params:{id:donation.project.id}}">
                                                        {{ donation.project.name }}
                                                    </router-link>
                                                </td>
                                                <td>{{ donation.amount }}</td>
                                                <td>{{ donation.note }}</td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <router-link :to="{name:'donationEdit', params:{id:donation.id}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Donation Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </router-link>
                                                    <button @click="deleteDonation(donation.id)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Donation" >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="modal fade" id="educational_history" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
            <div class="modal-dialog modal-sm400">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title title text-center transport_fees_title">Educational History</h4>
                    </div>
                    <div class="">
                        <div class="">
                            <div class="">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label >Education Type<small class="req" > *</small></label>
                                            <select v-model="form.education_type_id" autofocus="" class="form-control" >
                                                <option value="">Select Education Type</option>
                                                <option :value="education_type.id" v-for="education_type in education_types">{{education_type.name}}</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="people-certificate">Certificate</label>
                                            <input type="file" @change="certificateImage($event)" class="form-control people-certificate">
                                            <img v-if="form.certificate" :src="oldCertificate(form.certificate)" alt="" width="150px" height="50px" class="people-certificate">
                                        </div>
                                        <div class="form-group">
                                            <label >Note</label>
                                            <textarea v-model="form.note" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="clear:both">
                                        <button type="submit" @click.prevent="formReset" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                        <button v-if="form.education_historie_id ==''" type="submit" @click.prevent="addEducationHistory" class="btn btn-info pull-right">Save</button>
                                        <button v-else type="submit" @click.prevent="updateEducationHistory" class="btn btn-info pull-right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="history_of_medical" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
            <div class="modal-dialog modal-sm400">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title title text-center transport_fees_title">Medical History</h4>
                    </div>
                    <div class="">
                        <div class="">
                            <div class="">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Disease Name<small class="req" > *</small></label>
                                            <input type="text" v-model="medical.disease_name" class="form-control" placeholder="Disease Name">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Identify Date<small class="req" > *</small></label>
                                            <input type="date" v-model="medical.identify_date" class="form-control">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Cure Date<small class="req" > *</small></label>
                                            <input type="date" v-model="medical.cure_date" class="form-control">
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea cols="30" rows="5" v-model="medical.note" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="clear:both">
                                        <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                        <button v-if="medical.medical_history_id == ''" type="submit" @click.prevent="addMedicalHistory" class="btn btn-info pull-right">Save</button>
                                        <button v-else type="submit" @click.prevent="updateMedicalHistory" class="btn btn-info pull-right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="achievement_history" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
            <div class="modal-dialog modal-sm400">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title title text-center transport_fees_title">Achievement History</h4>
                    </div>
                    <div class="">
                        <form>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title<small class="req" > *</small></label>
                                    <input type="text" v-model="achievement.title" class="form-control" placeholder="Disease Name">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea cols="30" rows="5" v-model="achievement.details" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer" style="clear:both">
                                <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                <button v-if="achievement.achievement_id == ''" type="submit" @click.prevent="addAchievementHistory" class="btn btn-info pull-right">Save</button>
                                <button v-else type="submit" @click.prevent="updateAchievement" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ShowPeople",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        data(){
            return{
                education_types:[],
                people:[],
                education_histories:[],
                history_of_medicals:[],
                achievements:[],
                form:{
                    education_type_id: '',
                    note:'',
                    certificate:'',
                    people_id: '',
                    education_historie_id:''
                },
                medical:{
                    disease_name:'',
                    identify_date:'',
                    cure_date:'',
                    note:'',
                    files:'',
                    people_id: '',
                    medical_history_id:''
                },
                achievement:{
                    achievement_id:'',
                    title: '',
                    details: '',
                    file: '',
                    people_id: '',
                },
                errors:{}
            }
        },
        computed:{
            father(){
                if(this.people.father != null){
                    return this.people.father
                }
                return {name:this.people.father_name}
            },
            mother(){
                if(this.people.mother != null){
                    return this.people.mother
                }
                return {name:this.people.mother_name}
            },
        },
        watch: {
            peoples(val) {
                this.form.people_id = this.$route.params.id;
            }
        },
        mounted(){
            this.getPeople(this.$route.params.id);
            this.form.people_id = this.$route.params.id;
            this.medical.people_id = this.$route.params.id;
            this.achievement.people_id = this.$route.params.id;
            this.allEducationType();
            this.getMedicalHistories();
            this.getEducationHistories();
            this.resetData();
            this.medicalResetData();
            this.getAchievement();
            this.achievementResetData();
        },
        methods:{
            allEducationType(){
                axios.get('/api/education-type')
                    .then(res => {this.education_types = res.data})
                    .catch()
            },
            getEducationHistories(){
                axios.get('/api/education-history'+'?peopleId='+this.form.people_id)
                    .then(({data})=>this.education_histories = data)
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
            },
            getMedicalHistories(){
                axios.get('/api/medical-history'+'?peopleId='+this.medical.people_id)
                    .then(({data})=>this.history_of_medicals = data)
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
            },
            getAchievement(){
                axios.get('/api/achievement'+'?peopleId='+this.achievement.people_id)
                    .then(({data})=>this.achievements = data)
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
            },

            addEducationHistory(){
                axios.post('/api/education-history',this.form)
                    .then(res => {
                        toastr.success('Education History Add Successfully', {timeOut: 500});
                        $("#educational_history").modal('hide');
                        this.getEducationHistories();
                        this.resetData();
                        this.getPeople(id);
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            },
            addMedicalHistory(){
                axios.post('/api/medical-history',this.medical)
                    .then(res=>{
                        toastr.success('Medical History Update Successfully', {timeOut: 500});
                        $("#history_of_medical").modal('hide');
                        this.getMedicalHistories();
                        this.medicalResetData();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })
            },
            addAchievementHistory(){
                axios.post('/api/achievement',this.achievement)
                    .then(res=>{
                        toastr.success('Achievement History Update Successfully', {timeOut: 500});
                        $("#achievement_history").modal('hide');
                         this.getAchievement();
                         this.achievementResetData();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })
            },

            getPeople(id){
                axios.get('/api/people/'+ id)
                    .then(({data})=> (this.people = data))
                    .catch(error =>{
                        this.errors = error.response.data.errors
                    })
            },
            getFather(id){
                this.$router.push({name:'showPeople', params:{id:id}})
                this.getPeople(id);
            },
            getMother(id){
                this.$router.push({name:'showPeople', params:{id:id}})
                this.getPeople(id);
            },
            getAge(dateString){
                var today = new Date();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
                {
                    age--;
                }
                return age;
            },
            dateFormat(date){
                const event = new Date(date);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return event.toLocaleDateString(undefined, options);
            },

            editEducationHistorie(educationHistorie){
                this.form.education_type_id = educationHistorie.education_type_id;
                this.form.note = educationHistorie.note;
                this.form.certificate = educationHistorie.files;
                this.form.education_historie_id = educationHistorie.id;
            },
            editMedicalHistorie(medical_historie){
                this.medical.medical_history_id = medical_historie.id;
                this.medical.disease_name = medical_historie.disease_name;
                this.medical.identify_date = medical_historie.identify_date;
                this.medical.cure_date = medical_historie.cure_date;
                this.medical.note = medical_historie.note;

            },
            editAchievementHistorie(achievement){
                this.achievement.title = achievement.title;
                this.achievement.details = achievement.details;
                this.achievement.file = achievement.file;
                this.achievement.achievement_id = achievement.id;
            },

            updateEducationHistory(){
                var id = this.form.education_historie_id;
                axios.patch('/api/education-history/'+id,this.form)
                    .then(res=>{
                        toastr.success('Education History Update Successfully', {timeOut: 500});
                        $("#educational_history").modal('hide');
                        this.getEducationHistories();
                        this.resetData();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })
            },
            updateMedicalHistory(){
                var id = this.medical.medical_history_id;
                axios.patch('/api/medical-history/'+id,this.medical)
                    .then(res=>{
                        toastr.success('Education History Update Successfully', {timeOut: 500});
                        $("#history_of_medical").modal('hide');
                        this.getMedicalHistories();
                        this.medicalResetData();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })
            },
            updateAchievement(){
                var id = this.achievement.achievement_id;
                axios.patch('/api/achievement/'+id,this.achievement)
                    .then(res=>{
                        toastr.success('Achievement History Update Successfully', {timeOut: 500});
                        $("#achievement_history").modal('hide');
                        this.getAchievement();
                        this.achievementResetData();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })
            },

            deleteEducationHistory(id){
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
                        axios.delete('/api/education-history/'+id)
                            .then(() =>{
                                this.education_histories = this.education_histories.filter(education_historie=>{
                                    return education_historie.id != id
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.getEducationHistories();
                            })
                    }
                })
            },
            deleteMedicalHistory(id){
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
                        axios.delete('/api/medical-history/'+id)
                            .then(() =>{
                                this.history_of_medicals = this.history_of_medicals.filter(history_of_medical=>{
                                    return history_of_medical.id != id
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.getMedicalHistories();
                            })
                    }
                })
            },
            deleteAchievement(id){
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
                        axios.delete('/api/achievement/'+id)
                            .then(() =>{
                                this.achievements = this.achievements.filter(achievement=>{
                                    return achievement.id != id
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() =>{
                                _this.getAchievement();
                            })
                    }
                })
            },

            formReset(){
                this.resetData();
            },
            resetData(){
                this.form.education_type_id = '';
                this.form.note = '';
                this.form.certificate = '';
                this.form.education_historie_id='';
                this.errors=''
            },
            medicalResetData(){
                this.medical.medical_history_id = '';
                this.medical.disease_name = '';
                this.medical.identify_date = '';
                this.medical.cure_date = '';
                this.medical.note = '';
            },
            achievementResetData(){
                this.achievement.title = '';
                this.achievement.details = '';
                this.achievement.file = '';
                this.achievement.achievement_id = '';

            },
            deleteDonation(id) {
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
                        axios.delete('/api/donation/' + id)
                            .then(() => {
                                this.people.donations = this.people.donations.filter(donation => {
                                    return donation.id != id
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
                                    'success'
                                )
                            })
                            .catch((error) => {
                                var massage = this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Can Not Delete It!'
                                })
                            })


                    }
                })
            },
            imageLink(img,gender){
                if(img != null){
                    return '/upload/people/'+img;
                }
                else {
                    return '/default/'+gender+'.jpg';
                }
            },
            certificateImage(event){
                console.log(event.target.files[0]);
                let file = event.target.files[0];
                if(file.size > 1000000){
                    toastr.warning('Image Size Less Then 1 MB', {timeOut: 500});
                }
                else{
                    if (file.type == "image/jpeg" || file.type == "image/png" ){
                        let reader = new FileReader();
                        reader.onload = event =>{
                            this.form.certificate = event.target.result
                        };
                        reader.readAsDataURL(file);
                    }
                    else {
                        toastr.warning('Support Only jpg & png', {timeOut: 500});
                    }
                }
            },
            oldCertificate(img){
                if (img.length <= 100){
                    return '/upload/certificate/'+img;
                }
                else{
                    return this.form.certificate;
                }
            }
        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
    .genaratin{
        border: none;
        outline: none;
        cursor: pointer;
        background: #0d6aad;
        color: #fff;
        padding: 10px 20px;
    }
    label.people-certificate{
        display: block;
    }
    input[type=file]{
        opacity:1;
    }
    input.people-certificate{
        width: 60%;
        display: inline-block;
    }
    img.people-certificate{
        display: inline-block;
        width: 38%;
    }
    li.education_point {
        padding: 8px 15px!important;
    }

    li.education_point a {
        color: #fff!important;
        font-size: 21px;
        line-height: 18px;
    }
</style>