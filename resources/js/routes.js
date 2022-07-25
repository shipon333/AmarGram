var login = require('./components/auth/Login').default;
var register = require('./components/auth/Register').default;
var forgot = require('./components/auth/ForgetPassword').default;
var profile = require('./components/auth/Profile').default;
var logout = require('./components/auth/Logout').default;

// admin part
var adminDashboard = require('./components/admin/AdminDashboard').default;

// settings
var division = require('./components/admin/Division').default;
var district = require('./components/admin/District').default;
var upozilla = require('./components/admin/Upozilla').default;
var union = require('./components/admin/Union').default;
var organizationType = require('./components/admin/OrganizationType').default;
var educationType = require('./components/admin/EducationType').default;
var organizationRegistration = require('./components/organization/Registration').default;


// organization part
var dashboard = require('./components/organization/Dashboard').default;
var para = require('./components/organization/settings/Para').default;
var committeeDesignation = require('./components/organization/settings/CommitteeDesignation').default;
var memberType = require('./components/organization/settings/MemberType').default;
var addPeople = require('./components/organization/people/AddPeople').default;
var peopleList = require('./components/organization/people/PeopleList').default;
var editPeople = require('./components/organization/people/EditPeople').default;
var showPeople = require('./components/organization/people/ShowPeople').default;
var projectList = require('./components/organization/project/ProjectList').default;
var viewProject = require('./components/organization/project/ViewProject').default;
var donationList = require('./components/organization/donation/DonationList').default;
var donationCreate = require('./components/organization/donation/DonationCreate').default;
var donationEdit = require('./components/organization/donation/DonationEdit').default;
var accountList = require('./components/organization/AccountList').default;
var committee = require('./components/organization/committee/Committee').default;
var member = require('./components/organization/Member').default;
var committeeDetails = require('./components/organization/committee/CommitteeDetails').default;
var incomeType = require('./components/organization/settings/IncomeType').default;
var expenseType = require('./components/organization/settings/ExpenseType').default;
var expenseList = require('./components/organization/expense/ExpenseList').default;
var expenseCreate = require('./components/organization/expense/ExpenseCreate').default;
var expenseEdit = require('./components/organization/expense/ExpenseEdit').default;
var investmentList = require('./components/organization/investment/InvestmentList').default;
var viewInvestment = require('./components/organization/investment/ViewInvestment').default;

var addCitizenCharter = require('./components/organization/Citizen/AddCitizenCharter').default;
var viewCitizenCharter = require('./components/organization/Citizen/ViewCitizenCharter').default;
var editCitizenCharter = require('./components/organization/Citizen/EditCitizenCharter').default;

var incomeList = require('./components/organization/income/IncomeList').default;
var incomeCreate = require('./components/organization/income/IncomeCreate').default;
var incomeEdit = require('./components/organization/income/IncomeEdit').default;

export const routes = [
    { path: '/', component: login, name:'/' },
    // { path: '/register', component: register, name:'register' },
    { path: '/forgot', component: forgot, name:'forgot' },
    { path: '/profile', component: profile, name:'profile' },
    { path: '/logout', component: logout, name:'logout' },

    // admin part route
    { path: '/admin/dashboard', component: adminDashboard, name:'adminDashboard' },
    // settings route
    { path: '/division', component: division, name:'division' },
    { path: '/district', component: district, name:'district' },
    { path: '/upozilla', component: upozilla, name:'upozilla' },
    { path: '/union', component: union, name:'union' },
    { path: '/organization-type', component: organizationType, name:'organizationType' },
    { path: '/education-type', component: educationType, name:'educationType' },

    // organization part route
    { path: '/dashboard', component: dashboard, name:'dashboard' },
    { path: '/organization/registration', component: organizationRegistration, name:'organizationRegistration' },
    { path: '/para', component: para, name:'para' },
    { path: '/member/type', component: memberType, name:'memberType' },
    { path: '/committee/designation', component: committeeDesignation, name:'committeeDesignation' },
    { path: '/add-people', component: addPeople, name:'addPeople' },
    { path: '/peoples', component: peopleList, name:'peopleList' },
    { path: '/edit-people/:id', component: editPeople, name:'editPeople' },
    { path: '/show-people/:id', component: showPeople, name:'showPeople' },
    { path: '/projects', component: projectList, name:'projectList' },
    { path: '/project/details/:id', component: viewProject, name:'viewProject' },
    { path: '/donations', component: donationList, name:'donationList' },
    { path: '/donation/create', component: donationCreate, name:'donationCreate' },
    { path: '/donation/edit/:id', component: donationEdit, name:'donationEdit' },
    { path: '/accounts', component: accountList, name:'accountList' },
    { path: '/committee', component: committee, name:'committee' },
    { path: '/member', component: member, name:'member' },
    { path: '/committee/details/:id', component: committeeDetails, name:'committeeDetails' },
    { path: '/income-type', component: incomeType, name:'incomeType' },
    { path: '/expense-type', component: expenseType, name:'expenseType' },
    { path: '/expenses', component: expenseList, name:'expenseList' },
    { path: '/expense/create', component: expenseCreate, name:'expenseCreate' },
    { path: '/expense/edit/:id', component: expenseEdit, name:'expenseEdit' },
    { path: '/investments', component: investmentList, name:'investmentList' },
    { path: '/investment/details/:id', component: viewInvestment, name:'viewInvestment' },

    { path: '/add-citizen-charter', component: addCitizenCharter, name:'addCitizenCharter' },
    { path: '/view-citizen-charter', component: viewCitizenCharter, name:'viewCitizenCharter' },
    { path: '/citizen-charter/edit/:id', component: editCitizenCharter, name:'editCitizenCharter' },

    { path: '/incomes', component: incomeList, name:'incomeList' },
    { path: '/income/create', component: incomeCreate, name:'incomeCreate' },
    { path: '/income/edit/:id', component: incomeEdit, name:'incomeEdit' },

];