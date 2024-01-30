import { defineStore } from "pinia";
const defaultState = () => {
    return {
        allSkills: [],
        address: {
            address1: "",
            address2: "",
            latitude: "",
            longitude: "",
            city: "",
            state: "",
            zip_code: "",
            country: "",
            county: "",
        },

        userDetails: {
            name: "",
            email: "",
            phone: "",
        },
        educationDetails: [
            {
                education_type: "",
                school_university: "",
                starting_year: "",
                passing_year: "",
                passing_year_options: [],
                still_pursuing: false,
            },
        ],
        educationTypes: ["High School", "College", "University"],
        yearOptions: [2022, 2023, 2024],
        highest_education_path: null,
        still_pursuing: false,

        experience: [
            {
                company_name: "",
                position: "",
                description: "",
                start_date: null,
                expiry_date: null,
            },
        ],
        fields: [{ hobbies: "", strengths: "" }],
        hobbies: "",
        strengths: "",
        userSkills: [],

        achievements: [
            {
                certification_name: "",
                company_name: "",
                certificate_number: "",
                expiry_date: null,
                certificate_file_path: null,
            },
        ],
    };
};

export const useMyStore = defineStore("myStore", {
    id: "user",
    state: () => defaultState(),
    actions: {
        setEducation(education) {
            Object.assign(this.educationDetails, education);
        },
        addEducationEntry() {
            this.educationDetails.push({
                education_type: "",
                school_university: "",
                starting_year: "",
                passing_year: "",
            });
        },

        removeEducationEntry(index) {
            if (this.educationDetails.length > 1) {
                this.educationDetails.splice(index, 1);
            }
        },
        addWorkExperience() {
            this.experience.push({
                company_name: "",
                position: "",
                description: "",
                start_date: null,
                expiry_date: null,
            });
        },
        removeWorkExperience(index) {
            if (this.experience.length > 1) {
                this.educationDetails.splice(index, 1);
            }
        },
        updatePassingYearOptions(index) {
            const selectedStartingYear =
                this.educationDetails[index].starting_year;
            this.educationDetails[index].passing_year = null;
            this.educationDetails[index].passing_year_options =
                this.yearOptions.filter((year) => year >= selectedStartingYear);
        },
        addAchievement() {
            this.achievements.push({
                certification_name: "",
                company_name: "",
                certificate_number: "",
                expiry_date: null,
                certificate_file_path: null,
            });
        },
        removeAchievement(index) {
            if (this.achievements.length > 1) {
                this.achievements.splice(index, 1);
            }
        },
        addSkill(selectedSkill) {
            if (
                selectedSkill &&
                !this.selectedSkills.find(
                    (skill) => skill.id === selectedSkill.id
                )
            ) {
                this.selectedSkills.push(selectedSkill);
            }
        },
        setSkills(newSkills) {
            this.skills = newSkills;
        },

        addFields() {
            this.fields.push({
                hobbies: "",
                strengths: "",
            });
        },
        removeFields(index) {
            if (this.fields.length > 1) {
                this.fields.splice(index, 1);
            }
        },
        async fetchSkills() {
            try {
                const { data } = await axios.get("/skills");
                this.allSkills = data.skills;
            } catch (error) {
                console.error("Error fetching skills:", error);
            }
        },
        addSkill(selectedSkill) {
            if (
                selectedSkill &&
                !this.selectedSkills.find(
                    (skill) => skill.id === selectedSkill.id
                )
            ) {
                this.selectedSkills.push(selectedSkill);
            }
        },

        // Add other methods to update/store data as needed

        setFormData(formData) {
            Object.assign(this, formData);
        },
        clearFormData() {
            Object.assign(this, defaultState());
        },
        setUser(user) {
            Object.assign(this.userDetails, user);
        },
        setSkills(user) {
            Object.assign(this.skills, user);
        },
        submitForm() {
            const submittedData = {
                userDetails: this.userDetails,
                educationDetails: this.educationDetails,
                address: this.address,
                achievements: this.achievements,
                workExperiences: this.workExperiences,
            };
            console.log("here ", submittedData);
            axios.post("/submit", submittedData)
                .then(({ data }) => {
                    console.log("response", data);

                    // TODO: Clear state and show message
                })
                .catch((error) => {
                    console.log("Error", error);
                });
        },
    },
});
export const useUserDetailsStore = defineStore({
    id: "userDetails",
    state: () => ({
        name: "",
        email: "",
        phone: "",
    }),
    actions: {
        setUserData(userData) {
            Object.assign(this, userData);
        },
        clearUserData() {
            this.name = "";
            this.email = "";
            this.phone = "";
        },
    },
});
export const useResumeStore = defineStore("resume", {
    state: () => ({
        userDetails: {},
        educationDetails: {},
        fields: {},
        address: {},
        achievements: {},
        workExperiences: {},
    }),
    actions: {
        submitForm(submittedData) {},
    },
});
export const useEducationDetailsStore = defineStore("educationDetails", {
    state: () => ({
        educationDetails: [
            {
                education_type: "",
                school_university: "",
                starting_year: "",
                passing_year: "",
                passing_year_options: [],
                still_pursuing: false,
            },
        ],
        educationTypes: ["High School", "College", "University"],
        yearOptions: [2022, 2023, 2024],
        highest_education_path: null,
        still_pursuing: false,
    }),

    actions: {
        addEducationEntry() {
            this.educationDetails.push({
                education_type: "",
                school_university: "",
                starting_year: "",
                passing_year: "",
            });
        },

        removeEducationEntry(index) {
            if (this.educationDetails.length > 1) {
                this.educationDetails.splice(index, 1);
            }
        },

        updatePassingYearOptions(index) {
            const selectedStartingYear =
                this.educationDetails[index].starting_year;
            this.educationDetails[index].passing_year = null;
            this.educationDetails[index].passing_year_options =
                this.yearOptions.filter((year) => year >= selectedStartingYear);
        },

        resetForm() {
            Object.assign(this, defaultState());
        },
    },
});

export const useWorkExperienceStore = defineStore({
    id: "workExperience",
    state: () => ({
        company_name: "",
        position: "",
        description: "",
        start_date: null,
        expiry_date: null,
    }),
    actions: {
        setWorkExperienceFormData(formData) {
            Object.assign(this, formData);
        },
        clearWorkExperienceFormData() {
            this.company_name = "";
            this.position = "";
            this.description = "";
            this.start_date = null;
            this.expiry_date = null;
        },
    },
});

export const useUserProfileStore = defineStore({
    id: "userProfile",
    state: () => ({
        hobbies: "",
        strengths: "",
    }),
    actions: {
        setUserProfileFormData(formData) {
            Object.assign(this, formData);
        },
        clearUserProfileFormData() {
            this.hobbies = "";
            this.strengths = "";
        },
    },
});
export const useUserSkillsStore = defineStore({
    id: "userSkills",
    state: () => ({
        selectedSkills: [],
    }),
    actions: {
        addSelectedSkill(skill) {
            if (
                !this.selectedSkills.find(
                    (selectedSkill) => selectedSkill.id === skill.id
                )
            ) {
                this.selectedSkills.push(skill);
            }
        },
        removeSelectedSkill(skill) {
            this.selectedSkills = this.selectedSkills.filter(
                (selectedSkill) => selectedSkill.id !== skill.id
            );
        },
        clearSelectedSkills() {
            this.selectedSkills = [];
        },
    },
});

export const useUserAchievementsStore = defineStore({
    id: "userAchievements",
    state: () => ({
        certification_name: "",
        company_name: "",
        certificate_number: "",
        expiry_date: null,
        certificate_file_path: null,
    }),
    actions: {
        setUserAchievementsFormData(formData) {
            Object.assign(this, formData);
        },
        clearUserAchievementsFormData() {
            this.certification_name = "";
            this.company_name = "";
            this.certificate_number = "";
            this.expiry_date = null;
            this.certificate_file_path = null;
        },
    },
});

export default useMyStore;
