<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-money"></i> Edit Donation</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form>
                            <div class="box-body">
                                <div class="row">
                                    <div v-show="!form.donor_name" class="col-md-6">
                                        <div class="form-group">
                                            <label for="donorName">Select Donor</label><small class="req"> *</small>
                                            <select v-model="form.people_id" id="donorName" class="form-control" >
                                                <option value="">Select Donor</option>
                                                <option :value="people.id" v-for="people in peoples">{{people.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.people_id">{{errors.people_id[0]}}</small>
                                        </div>
                                    </div>
                                    <div v-show="!form.people_id" class="col-md-6">
                                        <div class="form-group">
                                            <label>Donor Name</label><small class="req"> *</small>
                                            <input v-model="form.donor_name"  placeholder="or Type Donor Name" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.donor_name">{{errors.donor_name[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Donate</label><small class="req"> *</small>
                                            <input v-model="form.donation_date"  placeholder="Donation Date" type="date" class="form-control">
                                            <small class="text-danger" v-if="errors.donation_date">{{errors.donation_date[0]}}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project">Project Name</label>
                                            <select v-model="form.project_id" id="project" class="form-control" >
                                                <option value="">Select Project</option>
                                                <option :value="project.id" v-for="project in projects">{{project.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.project_id">{{errors.project_id[0]}}</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Donation Amount</label>
                                            <input v-model="form.amount"  placeholder="Donation Amount" type="text" class="form-control">
                                            <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">-->
                                        <!--<div class="form-group">-->
                                            <!--<label for="receivedBy">Received by</label><small class="req"> *</small>-->
                                            <!--<select v-model="form.received_by" id="receivedBy" class="form-control" >-->
                                                <!--<option value="">Select Received Person</option>-->
                                                <!--<option :value="people.id" v-for="people in peoples">{{people.name}}</option>-->
                                            <!--</select>-->
                                            <!--<small class="text-danger" v-if="errors.received_by">{{errors.received_by[0]}}</small>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Comment/Note</label>
                                            <textarea v-model="form.note"  placeholder="Note" class="form-control" rows="5"></textarea>
                                            <small class="text-danger" v-if="errors.note">{{errors.note[0]}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button  type="reset" class="btn btn-danger pull-left">Reset</button>
                                <button type="submit" @click.prevent="updateDonation" class="btn btn-success pull-right">Save Donation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

    export default {
        name: "DonationEdit",
        beforeCreate(){
            if (!User.loggedIn()){
                this.$router.push({name:'/'})
            }
            if ( User.loggedIn() && User.userType() != "org") {
                this.$router.back();
            }
        },
        mounted(){
            console.log(User.id())
            this.getProjects();
            this.getPeoples();
        },
        computed:{
        },
        data(){
            return{
                donation:[],
                projects:[],
                peoples:[],
                form:{
                    donor_name: '',
                    people_id: '',
                    project_id: '',
                    amount: '',
                    // received_by: '',
                    note: '',
                },
                errors:{}
            }
        },
        created(){
            var id = this.$route.params.id
            axios.get('/api/donation/'+id)
                .then(({data})=> (this.form = data))
                .catch(error =>{
                    this.errors = error.response.data.errors
                })
        },
        methods: {
            getProjects(){
                axios.get('/api/projects/active'+'?userId='+User.id())
                    .then(({data}) => (this.projects = data))
                    .catch()
            },
            getPeoples(){
                axios.get('/api/peoples/list'+'?villageId='+User.villageId())
                    .then(({data}) => (this.peoples = data))
                    .catch()
            },
            updateDonation(){
                var id = this.$route.params.id;
                axios.patch('/api/donation/'+id,this.form)
                    .then(res => {
                        this.$router.push({name:'donationList'});
                        toastr.success('Donation Update Successfully', {timeOut: 500});

                    })
                    .catch()
            },

        }
    }
</script>

<style scoped>
    .content{
        margin-left: 200px;
    }
</style>