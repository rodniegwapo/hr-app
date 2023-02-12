<template>
  <div>
    <div class="flex w-full justify-content-end px-5 pt-4">
      <div class="text-gray text-3xl">Profile</div>
    </div>
    <div class="px-4 pb-4">
      <Fieldset legend="Personal Details">
        <div class="flex flex-wrap w-full justify-content-between">
          <div
            class="w-30"
            v-for="(personal, key) in personalDetails"
            :key="key"
          >
            <label for="email1" class="block text-900 font-medium mb-2">{{
              personal.label
            }}</label>
            <InputText
              id="email1"
              type="text"
              class="w-full mb-3"
              placeholder=""
            />
          </div>
        </div>
      </Fieldset>
      <Fieldset legend="Contact Details" class="mt-4">
        <div class="flex flex-wrap w-full">
          <div
            class="w-30 pr-1"
            v-for="(contact, key) in contactDetails"
            :key="key"
          >
            <label for="email1" class="block text-900 font-medium mb-2">{{
              contact.label
            }}</label>
            <InputText
              id="email1"
              type="text"
              class="w-full mb-3"
              placeholder=""
            />
          </div>
        </div>
      </Fieldset>
      <Fieldset legend="Address Details" class="mt-4">
        <div class="flex flex-wrap w-full">
          <div
            class="w-30 pr-1"
            v-for="(address, key) in addressDetails"
            :key="key"
          >
            <label for="email1" class="block text-900 font-medium mb-2">{{
              address.label
            }}</label>
            <InputText
              id="email1"
              type="text"
              class="w-full mb-3"
              placeholder=""
            />
          </div>
        </div>
      </Fieldset>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      personalDetails: [
        { name: "firstname", label: "First Name" },
        { name: "lastname", label: "Last Name" },
        { name: "email", label: "Email" },
        { name: "birthday", label: "BirthDay" },
        { name: "birth-place", label: "Birth Place" },
        { name: "nationality", label: "Nationality" },
        { name: "marital-status", label: "Marital Status" },
        { name: "marriage-date", label: "Marriage Date" },
        { name: "spouse-name", label: "Spouse Name" },
      ],
      personalityForm: {
        firstname: "",
        lastname: "",
        email: "",
        birthday: "",
        "birth-place": "",
        nationality: "",
        "marital-status": "",
        "marriage-date": "",
        "spouse-name": "",
      },
      contactDetails: [
        { name: "home-phone", label: "Home Phone" },
        { name: "work-phone", label: "Work Phone" },
        { name: "mobile-phone", label: "Mobile Phone" },
        { name: "other-phone", label: "Other Phone" },
        { name: "alternate-email", label: "Alternate Email" },
        { name: "emergency-phone", label: "Emergency Phone" },
        { name: "emergency-contact-name", label: "Emergency Contact Name" },
        { name: "emergency-relation", label: "Emergency Relation" },
      ],
      contactForm: {
        "home-phone": "",
        "work-phone": "",
        "mobile-phone": "",
        "other-phone": "",
        "alternate-email": "",
        "emergency-phone": "",
        "emergency-contact-name": "",
        "emergency-relation": "",
      },
      addressDetails: [
        { name: "address", label: "Address" },
        { name: "city", label: "City" },
        { name: "state-province", label: "State/Province" },
        { name: "country", label: "Country" },
        { name: "zip", label: "Zip/Postal Code" },
      ],
      addressForm: {
        address: "",
        city: "",
        "state-province": "",
        country: "",
        zip: "",
      },
    };
  },
};
</script>