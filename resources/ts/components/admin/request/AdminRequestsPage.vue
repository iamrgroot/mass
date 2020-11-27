<template>
    <v-card :loading="requests_loading">
        <v-card-title>
            <span>Requests</span>
            <v-spacer />
            <v-btn
                text
                class="ma-2"
                @click="add_dialog = true"
            >
                New
            </v-btn>
            <v-btn
                icon
                class="ma-2"
                @click="fetchRequests"
            >
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            <v-fade-transition mode="out-in">
                <v-data-table
                    :headers="headers"
                    :items="requests"
                    :items-per-page="-1"
                    mobile-breakpoint="0"
                    :hide-default-header="is_mobile"
                >
                    <template #[`item.image_url`]="{ item }">
                        <image-preview
                            :src="getImageURL(item.type, item.image_url)"
                            right
                        />
                    </template>
                    <template #[`item.type`]="{ value }">
                        {{ itemString(value) }}
                    </template>
                    <template #[`item.created_at`]="{ value }">
                        <date-chip :date="value" />
                    </template>
                    <template #[`item.updated_at`]="{ value }">
                        <date-chip :date="value" />
                    </template>
                    <template #[`item.status`]="{ value }">
                        <icon-tooltip
                            :icon="value.icon"
                            :text="value.text"
                            :color="value.color"
                        />
                    </template>
                    <template #[`item.actions`]="{ item }">
                        <template v-if="item.status.value === RequestStatus.Request">
                            <v-icon
                                color="green"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Approved)"
                            >
                                {{ RequestStatusIcon.Approved }}
                            </v-icon>
                            <v-icon
                                color="red"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Denied)"
                            >
                                {{ RequestStatusIcon.Denied }}
                            </v-icon>
                        </template>
                        <template v-else-if="item.status.value === RequestStatus.Error">
                            <icon-tooltip
                                :icon="item.status.icon"
                                text="See system log for error. Click to try again."
                                :color="item.status.color"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Approved)"
                            />
                        </template>
                        <template v-else-if="item.status.value === RequestStatus.Download">
                            <v-icon
                                color="success"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Done)"
                            >
                                {{ RequestStatusIcon.Done }}
                            </v-icon>
                            <v-icon
                                color="error"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Error)"
                            >
                                {{ RequestStatusIcon.Error }}
                            </v-icon>
                        </template>
                        <template v-if="item.status.value === RequestStatus.Denied">
                            <icon-tooltip
                                :icon="RequestStatusIcon.Request"
                                text="Reset"
                                color="primary"
                                :class="icon_padding"
                                @click="updateRequest(item, RequestStatus.Request)"
                            />
                        </template>
                        <v-icon
                            color="error"
                            :class="icon_padding"
                            @click="removeRequest(item)"
                        >
                            $mdiDelete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-fade-transition>
        </v-card-text>

        <add-dialog
            v-model="add_dialog"
            request
        />
    </v-card>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, SetupContext, toRefs } from '@vue/composition-api';
import { DataTableHeader } from 'vuetify';

import AddDialog from '@/components/user/AddDialog.vue';
import IconTooltip from '@/components/defaults/IconTooltip.vue';
import DateChip from '@/components/defaults/DateChip.vue';
import ImagePreview from '@/components/defaults/ImagePreview.vue';

import { ItemType } from '@/enums/ItemType';

import { useRequests } from '@/store/requests';

import { getImageURL } from '@/helpers/images';
import { RequestStatus, RequestStatusIcon, RequestStatusName } from '@/enums/RequestStatus';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useRequestTable = (vm: SetupContext) => {
    const table_data = reactive({
        add_dialog: false,
    });

    const is_mobile = computed((): boolean => {
        return vm.root.$vuetify.breakpoint.xs;
    });

    const headers = computed((): DataTableHeader[] => {
        if (! is_mobile.value) {
            return [
                { text: '', value: 'image_url' },
                { text: 'Type', value: 'type' },
                { text: 'Name', value: 'text' },
                { text: 'Created at', value: 'created_at' },
                { text: 'Updated at', value: 'updated_at' },
                { text: 'Status', value: 'status' },
                { text: 'Actions', value: 'actions', width: '200px', sortable: false, align: 'end' },
            ] as DataTableHeader[];
        }

        return [
            { text: 'Type', value: 'type' },
            { text: 'Name', value: 'text' },
            { text: 'Status', value: 'status' },
            { text: 'Actions', value: 'actions', sortable: false, align: 'end' },
        ] as DataTableHeader[];
    });

    const icon_padding = computed((): string => {
        return is_mobile.value ? 'my-2' : 'ml-3';
    });

    const itemString = (type: ItemType): string => type === ItemType.Movie ? 'Movie' : 'Serie';

    return {
        ...toRefs(table_data),
        is_mobile,
        headers,
        icon_padding,
        itemString,
        getImageURL,
    };
};

export default defineComponent({
    components: {
        AddDialog,
        DateChip,
        IconTooltip,
        ImagePreview,
    },
    setup(props, vm) {
        return {
            ...useRequests(),
            ...useRequestTable(vm),
            RequestStatus,
            RequestStatusIcon,
            RequestStatusName
        };
    },
    created() {
        this.fetchRequests();
    },
});
</script>