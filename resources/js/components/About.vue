<template>
  <div class="message_page">
    <v-row>
      <div sm="12" md="12" lg="4" xl="4" cols="12">
        <v-card>
          <v-form fast-fail @submit.prevent>
            <v-text-field
              v-model="search"
              :rules="search"
              label="Search"
            ></v-text-field>
          </v-form>
          <v-card>
            <v-list-item>
              <template v-slot:prepend>
                <v-avatar
                  color="grey-darken-3"
                  image="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                ></v-avatar>
              </template>
              <v-list-item-title>Evan You</v-list-item-title>
              <v-list-item-subtitle>Vue Creator</v-list-item-subtitle>
              <template v-slot:append>
                <div class="justify-self-end">
                  <span class="subheading me-2">256 mins</span>
                </div>
              </template>
            </v-list-item>
          </v-card>
        </v-card>
      </div>
      <div sm="12" md="12" lg="8" xl="8" cols="12">
        <div class="you_user">
          <v-card>
            <v-list-item>
              <template v-slot:prepend>
                <v-avatar
                  color="grey-darken-3"
                  image="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                ></v-avatar>
              </template>
              <v-list-item-title>Candidates Name</v-list-item-title>
              <v-list-item-subtitle>Active</v-list-item-subtitle>
              <template v-slot:append>
                <div class="justify-self-end">
                  <span class="subheading me-2">Delete Conversation</span>
                </div>
              </template>
            </v-list-item>
          </v-card>
        </div>
        <div class="message_section">
          <v-card>
            <v-card-text>
              <div class="font-weight-bold ms-1 mb-2">Today</div>
              <v-timeline>
                <v-timeline-item
                  v-for="items in items"
                  :key="items.time"
                  size="x-small"
                >
                  <div class="mb-4">
                    <div>
                      <strong>{{ items.from }}</strong> @{{ items.time }}
                    </div>
                    <div>{{ items.message }}</div>
                  </div>
                </v-timeline-item>
              </v-timeline>
            </v-card-text>
          </v-card>
        </div>
        <div class="send_btn_and_message_tp">
          <v-sheet class="mx-auto">
            <v-form fast-fail @submit.prevent>
              <v-textarea
                rows="3"
                label="Label"
                variant="filled"
                auto-grow
              ></v-textarea>
              <v-btn class="mt-2" type="submit" block>Send Message</v-btn>
            </v-form>
          </v-sheet>
        </div>
      </div>
    </v-row>
  </div>
</template>
<script>
export default {
  setup() {
    const items = [
      {
        from: "You",
        message: `Sure, I'll see you later.`,
        time: "10:42am",
      },
      {
        from: "John Doe",
        message: "Yeah, sure. Does 1:00pm work?",
        time: "10:37am",
      },
      {
        from: "You",
        message: "Did you still want to grab lunch today?",
        time: "9:47am",
      },
    ];
    return {
      items,
      value: 1151.71,
      myOption: {
        duration: 3000,
        characterWidth: 12,
        // addCharacter: ['♪', '€', '£', '$', '¥', ','],
        decimals: 2,
        thousandsSeparatorFlag: true,
        //
      },
    };
  },
};
</script>
<style>
.message_page {
  margin: 25px 0;
}
.message_page .v-timeline-divider {
  display: none;
}
</style>