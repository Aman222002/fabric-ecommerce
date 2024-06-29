import { defineStore } from "pinia";
import axios from "axios";

const educationItem = {
    id: null,
    education_type: "",
    school_university: "",
    starting_year: "",
    passing_year: "",
    passing_year_options: [],
    still_pursuing: false,
};

const expItem = {
    id: null,
    company_name: "",
    position: "",
    description: "",
    start_date: null,
    end_date: null,
    currently_working: false
};

const achievementItem = {
    id: null,
    certification_name: "",
    company_name: "",
    certificate_number: "",
    expiry_date: null,
    certificate_file: [],
    certificate_file_path: null,
};

const defaultState = () => {
    return {
        selectedSkills: [],
        userProfile: {
            hobbies: "",
            strengths: "",
        },

        // allSkills: [],
        address: {
            address1: "",
            address2: "",
            latitude: "",
            longitude: "",
            city: "",
            state: "",
            zip_code: "",
            country: "",
            county: null,
        },

        userDetails: {
            name: "",
            email: "",
            phone: "",
            status: [],
            user_image:[],
        },
        educationDetails: [educationItem],

        educationTypes: ["High School", "College", "University"],
        yearOptions: [2022, 2023, 2024],
        highest_education_path: null,
        still_pursuing: false,
        experience: [expItem],
        userProfile: [
            {
                hobbies: "",
                strengths: "",
            },
        ],
        // fields: { hobbies: "", strengths: "" },

        userSkills: [],
        achievements: [achievementItem],
    };
};

export const useMyStore = defineStore("myStore", {
    id: "user",
    state: () => defaultState(),
    actions: {
        addSkill(skill) {
            if (!this.selectedSkills.find((s) => s.id === skill.id)) {
                this.selectedSkills.push(skill);
            }
        },
        removeSkill(skillId) {
            this.selectedSkills = this.selectedSkills.filter(
                (s) => s.id !== skillId
            );
        },
        updateSkills(skills) {
            this.selectedSkills = [...skills];
        },
        clearSelectedSkills() {
            this.selectedSkills = [];
        },

        setEducation(education) {
            Object.assign(this.educationDetails, education);
        },
        addEducationEntry() {
            this.educationDetails.push(educationItem);
        },

        removeEducationEntry(index) {
            if (this.educationDetails.length > 1) {
                this.educationDetails.splice(index, 1);
            }
        },
        addWorkExperience() {
            this.experience.push(expItem);
            this.updateIsExperience();
        },

        removeWorkExperience(index) {
            if (this.experience.length > 1) {
                this.experience.splice(index, 1);
                this.updateIsExperience();
            }
        },
        AddAchievement() {
            this.achievements.push(achievementItem);
            this.updateIsExperience();
        },
        removeAchievement(index) {
            if (this.achievements.length > 1) {
                this.achievements.splice(index, 1);
                this.updateIsExperience();
            }
        },
        updateIsExperience() {
            this.isExperience = !!(
              this.experience.length ||
              this.achievements.length
            );
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

        async fetchSkills() {
            console.log("Fetching skills...");
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

        setFormData(formData) {
            Object.assign(this, formData);
        },
        clearFormData() {
            Object.assign(this, defaultState());
        },
        setUser(user) {
            Object.assign(this.userDetails, user);
        },
        setAddress(user) {
            console.log(user);
            Object.assign(this.address, user);
        },
        setEducation(user) {
            console.log(user);
            Object.assign(this.educationDetails, user);
        },
        setProfile(user) {
            console.log(user);
            Object.assign(this.userProfile, user);
        },
        setAchievments(user) {
            console.log(user);
            Object.assign(this.achievements, user);
        },
        setExperience(user) {
            console.log(user);
            Object.assign(this.experience, user);
        },
        setSkills(user) {
            Object.assign(this.selectedSkills, user);
        },
        submitForm() {
            const formData = new FormData();
            formData.append("userDetails[name]", this.userDetails.name);
            formData.append("userDetails[email]", this.userDetails.email);
            formData.append("userDetails[phone]", this.userDetails.phone);
            formData.append("userDetails[user_image]", this.userDetails.user_image);
            formData.append("userDetails[status]", this.userDetails.status);
            formData.append("address[address1]", this.address.address1);
            formData.append("address[address2]", this.address.address2);
            formData.append("address[city]", this.address.city);
            formData.append("address[state]", this.address.state);
            formData.append("address[latitude]", this.address.latitude);
            formData.append("address[longitude]", this.address.longitude);
            formData.append("address[zip_code]", this.address.zip_code);
            formData.append("address[country]", this.address.country);
            formData.append("address[county]", this.address.county);
            formData.append("userProfile[hobbies]", this.userProfile.hobbies);
            formData.append(
                "userProfile[strengths]",
                this.userProfile.strengths
            );
            formData.append("selectedSkills", this.selectedSkills);

            for (let index = 0; index < this.educationDetails.length; index++) {
                const education = this.educationDetails[index];

                formData.append(
                    `educationDetails[${index}][education_type]`,
                    education.education_type
                );
                formData.append(
                    `educationDetails[${index}][school_university]`,
                    education.school_university
                );
                formData.append(
                    `educationDetails[${index}][starting_year]`,
                    education.starting_year
                );
                formData.append(
                    `educationDetails[${index}][passing_year]`,
                    education.passing_year?.toString() || ""
                );
            }
            for (let index = 0; index < this.experience.length; index++) {
                const experience = this.experience[index];

                formData.append(
                    `experience[${index}][company_name]`,
                    experience.company_name || ""
                );
                formData.append(
                    `experience[${index}][position]`,
                    experience.position || ""
                );
                formData.append(
                    `experience[${index}][description]`,
                    experience.description || ""
                );
                formData.append(
                    `experience[${index}][start_date]`,
                    experience.start_date 
                );
                formData.append(
                    `experience[${index}][end_date]`,
                    experience.end_date
                );
            }
            for (let index = 0; index < this.achievements.length; index++) {
                const achievement = this.achievements[index];

                formData.append(
                    `achievements[${index}][certification_name]`,
                    achievement.certification_name || ""
                );
                formData.append(
                    `achievements[${index}][company_name]`,
                    achievement.company_name || ""
                );
                formData.append(
                    `achievements[${index}][certificate_number]`,
                    achievement.certificate_number || ""
                );
                formData.append(
                    `achievements[${index}][expiry_date]`,
                    achievement.expiry_date || ""
                );

                formData.append(
                    `achievements[${index}][certificate_file_path]`,
                    achievement.certificate_file &&
                        achievement.certificate_file.length
                        ? achievement.certificate_file[0]
                        : achievement.certificate_file_path
                );
            }

            // formData.append("fields", JSON.stringify(this.fields));
            formData.append(
                "selectedSkills",
                JSON.stringify(this.selectedSkills)
            );

            axios.post("/submit", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                  },
            })
                .then(({ data }) => {
                    console.log("Response", data);
                    window.Swal.fire({
                        title: "Success!",
                        text: "Form submitted successfully.",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                })
                .catch((error) => {
                    window.Swal.fire({
                        title: "Error",
                        text: "Form  not submitted successfully.",
                        icon: "Error",
                        confirmButtonText: "OK",
                    });
                    console.log("Error", error);
                    if (error.response && error.response.status === 422) {
                        console.log(
                            "Validation Errors:",
                            error.response.data.errors
                        );
                    }
                });
        },

        getUserData() {
            axios
                .get("/my-profile")
                .then(({ data }) => {
                    if (data.status) {
                        const resp = data.data;

                        //Object.assign(this, data.data);
                        if (!resp.achievements.length) {
                            resp.achievements = [achievementItem];
                        }
                        if (!resp.educationDetails.length) {
                            resp.educationDetails = [educationItem];
                        }

                        if (!resp.experience.length) {
                            resp.experience = [expItem];
                        }
                        if (!resp.address) {
                            resp.address = JSON.parse(
                                JSON.stringify(this.address)
                            );
                        }
                        if (!resp.userProfile) {
                            resp.userProfile = JSON.parse(
                                JSON.stringify(this.userProfile)
                            );
                        }

                        this.$patch(resp);

                        // if (resp.userDetails) {
                        //     console.log("resp", resp.userDetails);
                        //     Object.keys(this.userDetails, resp.userDetails);
                        // }

                        // if (resp.address) {
                        //     Object.keys(this.address, resp.address);
                        // }

                        // if (resp.experience && resp.experience.length) {
                        //     Object.keys(this.experience, resp.experience);
                        // }

                        // if (resp.achievements && resp.achievements.length) {
                        //     Object.keys(this.achievements, resp.achievements);
                        // }

                        // this.hobbies = resp.hobbies;
                        // this.strengths = resp.strengths;

                        // Object.assign(
                        //     this.selectedSkills,
                        //     resp.selectedSkills ?? []
                        // );

                        // // this.educationDetails = resp.educationDetails;
                        // Object.assign(
                        //     this.educationDetails,
                        //     resp.educationDetails.length
                        //         ? resp.educationDetails
                        //         : [educationItem]
                        // );
                    }
                })
                .catch((err) => {
                    console.log("Error", err);
                });
        },
    },
    // persist: true,
});
export const useUserDetailsStore = defineStore({
    id: "userDetails",
    state: () => ({
        name: "",
        email: "",
        phone: "",
        status:[],
        user_image:[],
    }),
    actions: {
        setUserData(userData) {
            Object.assign(this, userData);
        },
        clearUserData() {
            this.name = "";
            this.email = "";
            this.phone = "";
            this.status=[];
            this.user_image=[];
        },
    },
     persist: true,
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
    persist: true,
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
    persist: true,
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
        addWorkExperience() {
            this.experience.push({
                id: null,
                company_name: "",
                position: "",
                description: "",
                start_date: null,
                expiry_date: null,
                currently_working: false

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
        clearWorkExperienceFormData() {
            this.company_name = "";
            this.position = "";
            this.description = "";
            this.start_date = null;
            this.expiry_date = null;
        },
    },
    persist: true,
});

export const useUserProfileStore = defineStore({
    id: "userProfile",
    state: () => ({
        fields: {
            hobbies: "",
            strengths: "",
        },
    }),
    actions: {
        setUserProfile(formData) {
            Object.assign(this.fields, formData);
        },
        clearUserProfileFormData() {
            this.fields = "";
        },
    },
    persist: true,
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
    persist: true,
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
persist: true,
});

export default useMyStore;
