<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-user-plus"></i> Edit Resident Information</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2">Basic Information</h4>

                                <div class="row around10">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Name</label><small class="req"> *</small>
                                            <input v-model="form.name" placeholder="Name" type="text" class="form-control" >
                                            <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                        </div>
                                    </div>
                                    <div v-show="!form.father_name" class="col-md-3">
                                        <div class="form-group">
                                            <label >Select Father</label> (<small class="req">If exist in system</small>)
                                            <select v-model="form.father_id"  class="form-control" >
                                                <option value="">Select Father</option>
                                                <option :value="father.id" v-for="father in peoples.male">
                                                    {{father.name}}
                                                    -
                                                    {{father.father_id !=null?father.father.name:father.father_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-show="!form.father_id" class="col-md-3">
                                        <div class="form-group">
                                            <label>Father Name</label>
                                            <input v-model="form.father_name" placeholder="Father Name" type="text" class="form-control" >
                                        </div>
                                    </div>
                                    <div v-show="!form.mother_name" class="col-md-3">
                                        <div class="form-group">
                                            <label >Select Mother</label> (<small class="req">If exist in system</small>)
                                            <select v-model="form.mother_id"  class="form-control" >
                                                <option value="">Select Mother</option>
                                                <option :value="mother.id" v-for="mother in peoples.female">
                                                    {{mother.name}}
                                                    -
                                                    {{mother.father_id !=null?mother.father.name:mother.father_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-show="!form.mother_id" class="col-md-3">
                                        <div class="form-group">
                                            <label>Mother Name</label>
                                            <input v-model="form.mother_name" placeholder="Mother Name" type="text" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date of Birth</label><small class="req"> *</small>
                                            <input v-model="form.dob" placeholder="DOB" type="date" class="form-control">
                                            <small class="text-danger" v-if="errors.dob">{{errors.dob[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input v-model="form.mobile_numbers" placeholder="Mobile Number" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.mobile_numbers">{{errors.mobile_numbers[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input v-model="form.email" placeholder="Email" type="email" class="form-control">
                                            <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label >Gender</label><small class="req"> *</small>
                                            <select v-model="form.gender"  class="form-control" >
                                                <option value="">Select Gender</option>
                                                <option value="Male" >Male</option>
                                                <option value="Female" >Female</option>
                                                <option value="Others" >Others</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.gender">{{errors.gender[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <select v-model="form.religion"  class="form-control" >
                                                <option value="">Select Religion</option>
                                                <option value="Muslim">Muslim</option>
                                                <option value="Hinduism">Hinduism</option>
                                                <option value="Buddhism">Buddhism</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <select v-model="form.blood_group"  class="form-control" >
                                                <option value="">Select Blood Group</option>
                                                <option value="A+" >A+</option>
                                                <option value="A-" >A-</option>
                                                <option value="B+" >B+</option>
                                                <option value="B-" >B-</option>
                                                <option value="O+" >O+</option>
                                                <option value="O-" >O-</option>
                                                <option value="AB+" >AB+</option>
                                                <option value="AB-" >AB-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Profession</label>
                                            <input v-model="form.profession" placeholder="Profession" type="text" class="form-control"  value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label >Marital Status</label><small class="req"> *</small>
                                            <select v-model="form.marital_status"  class="form-control" >
                                                <option value="">Select Marital Status</option>
                                                <option value="Married" >Married</option>
                                                <option value="Unmarried" >Unmarried</option>
                                                <option value="Divorced" >Divorced</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.marital_status">{{errors.marital_status[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Para</label><small class="req"> *</small>
                                            <select v-model="form.para_id"  class="form-control" >
                                                <option value="">Select Para</option>
                                                <option :value="para.id" v-for="para in paras" >{{para.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.para_id">{{errors.para_id[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Word No</label><small class="req"> *</small>
                                            <select v-model="form.ward_no"  class="form-control" >
                                                <option value="">Select Word</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>
                                                <option value="3" >3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.ward_no">{{errors.ward_no[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Profile Image</label><br>
                                            <input type="file" @change="avatarImage($event)" class="avatarImage">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <img v-if="form.avatar" :src="oldImage(form.avatar)" alt="" width="50px" height="50px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2">Other Information</h4>

                                <div class="row around10">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date of Die</label>
                                            <input v-model="form.dod" placeholder="DOD" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Height</label>
                                            <input v-model="form.height" placeholder="Height" type="text" class="form-control"  value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label >Weight</label>
                                            <input v-model="form.weight" placeholder="Weight" type="text" class="form-control"  value="">
                                        </div>
                                    </div>
                                    <div v-show="form.marital_status != 'Unmarried'" class="col-md-3">
                                        <div class="form-group">
                                            <label>Date of Marriage</label>
                                            <input v-model="form.dom" placeholder="DOM" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div v-show="form.marital_status != 'Unmarried' && !form.spouse_name" class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Spouse</label> (<small class="req">If exist in system</small>)
                                            <select v-model="form.spouse_id"  class="form-control" >
                                                <option value="">Select Spouse Name</option>
                                                <option :value="spouse.id" v-for="spouse in spouses">{{spouse.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-show="form.marital_status != 'Unmarried' && !form.spouse_id" class="col-md-3">
                                        <div class="form-group">
                                            <label>Spouse Name</label>
                                            <input v-model="form.spouse_name" placeholder="Spouse Name" type="text" class="form-control"  value="">
                                        </div>
                                    </div>
                                    <div v-show="form.marital_status != 'Unmarried' && !form.spouse_id" class="col-md-3">
                                        <div class="form-group">
                                            <label >Spouse Address</label>
                                            <input v-model="form.spouse_address" placeholder="Spouse Address" type="text" class="form-control"  value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label >Dependent On </label>
                                            <select v-model="form.dependent_on"  class="form-control" >
                                                <option value="">Select Dependent</option>
                                                <option :value="father.id" v-for="father in allpeoples">
                                                    {{father.name}}
                                                    -
                                                    {{father.father_id !=null?father.father.name:father.father_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2">Identity Information</h4>

                                <div class="row around10">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> NID</label>
                                            <input v-model="form.nid"  placeholder="NID" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.nid">{{errors.nid[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Birth Registration</label>
                                            <input v-model="form.birth_registration" placeholder="Birth Registration" type="text" class="form-control" >
                                            <small class="text-danger" v-if="errors.birth_registration">{{errors.birth_registration[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Passport Number</label>
                                            <input v-model="form.passport_no"  placeholder="Passport Number" type="text" class="form-control" >
                                            <small class="text-danger" v-if="errors.passport_no">{{errors.passport_no[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label >Driving License</label>
                                            <input v-model="form.driving_license" placeholder="Driving License" type="text" class="form-control" >
                                            <small class="text-danger" v-if="errors.driving_license">{{errors.driving_license[0]}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2">Miscellaneous  Information</h4>

                                <div class="row around10">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Old Age Allowance?</label><br>
                                            <input v-model="form.old_age_allowance" type="radio" name="old_age" value="1"> Yes
                                            <input v-model="form.old_age_allowance" type="radio" name="old_age" value="0"> No
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Is Freedom Fighter?</label><br>
                                            <input v-model="form.is_freedom_fighter" type="radio" name="fighter" value="1"> Yes
                                            <input v-model="form.is_freedom_fighter" type="radio" name="fighter" value="0"> No
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Freedom Fighter Allowance?</label><br>
                                            <input v-model="form.freedom_fighter_allowance" type="radio" name="fighter_allowance" value="1"> Yes
                                            <input v-model="form.freedom_fighter_allowance" type="radio" name="fighter_allowance" value="0"> No
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Is Disabled?</label><br>
                                            <input v-model="form.is_disabled" type="radio" name="is_disable" value="1"> Yes
                                            <input v-model="form.is_disabled" type="radio" name="is_disable" value="0"> No
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Disability Allowance</label><br>
                                            <input v-model="form.disability_allowance" type="radio" name="disable_allowance" value="1"> Yes
                                            <input v-model="form.disability_allowance" type="radio" name="disable_allowance" value="0"> No
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="box-footer">
                                <!--<button  type="submit" @click.prevent="formReset" class="btn btn-info pull-left">Reset</button>-->
                                <button type="submit" @click.prevent="updatePeople" class="btn btn-info pull-right">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

    export default {
        name: "EditPeople",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        mounted(){
            this.allPara();
            this.getPeople();
        },
        computed:{
            allpeoples(){
                var _peoples = this.peoples.male.concat(this.peoples.female);
                return _peoples.sort((a,b)=>(a.name > b.name ? 1:-1))
            },
            spouses(){
                var gender = this.form.gender;
                if (gender == 'Male'){
                    return this.peoples.female;
                }else if(gender == 'Female'){
                    return this.peoples.male;
                }
                return {}
            }
        },
        data(){
            return{
                paras:[],
                peoples:{
                    male:[],
                    female:[]
                },
                form:{
                    nid: '',
                    birth_registration: '',
                    passport_no : '',
                    driving_license : '',
                    name : '',
                    father_name : '',
                    father_id  : '',
                    mother_name : '',
                    mother_id  : '',
                    dob : '',
                    dod : '',
                    dom : '',
                    mobile_numbers : '',
                    email : '',
                    profession : '',
                    para_id : '',
                    marital_status : '',
                    spouse_name : '',
                    spouse_id  : '',
                    spouse_address : '',
                    blood_group : '',
                    religion : '',
                    dependent_on  : '',
                    old_age_allowance : '',
                    is_freedom_fighter : '',
                    freedom_fighter_allowance : '',
                    is_disabled : '',
                    disability_allowance : '',
                    ward_no : '',
                    height : '',
                    weight : '',
                    gender : '',
                    avatar : '',
                    user_id: User.id(),
                },
                errors:{}
            }
        },
        created(){
            var id = this.$route.params.id
            axios.get('/api/people/'+id)
                .then(({data})=> (this.form = data))
                .catch(error =>{
                    this.errors = error.response.data.errors
                })
        },
        methods: {
            allPara() {
                axios.get('/api/para'+'?villageId='+User.villageId())
                    .then(({data}) => (this.paras = data))
                    .catch()
            },
            getPeople(){
                var id = User.villageId();
                axios.get('/api/get-peoples/'+id)
                    .then(({data})=>(this.peoples = data))
                    .catch(error => {
                        this.errors = error.response.data.errors

                    })


            },
            updatePeople(){
                var id = this.$route.params.id;
                var _this = this;
                axios.patch('/api/people/'+id,this.form)
                    .then(res => {
                        this.$router.push({name:'peopleList'});
                        toastr.success('People Update Successfully', {timeOut: 500});
                    })
                    .catch(error => {
                        console.log(error);
                        _this.errors = error.response.data.errors

                    })
            },
            avatarImage(event){
                let file = event.target.files[0];
                if(file.size > 1000000){
                    toastr.warning('Image Size Less Then 1 MB', {timeOut: 500});
                }
                else{
                    if (file.type == "image/jpeg" || file.type == "image/png"){
                        let reader = new FileReader();
                        let v_this = this;
                        reader.onload = event =>{
                            this.form.avatar = event.target.result
                            console.log(event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                    else {
                        toastr.warning('Support Only jpg & png', {timeOut: 500});
                    }
                }
            },
            oldImage(img){
                console.log(img.length);
                if(img.length <= 100){
                    return '/upload/people/'+img;
                }
                else{
                    return this.form.avatar
                }
            }

        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
    .avatarImage{
        opacity: 1;
    }
</style>