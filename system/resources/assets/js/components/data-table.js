import { get } from 'axios';
import deepAssign from 'deep-assign';
import debounce from 'lodash.debounce';
import { getPaginationArray, getNested } from '../utils';

const DataDisplay = {
    props: ['entry', 'column'],
    computed: {
        value() {
            return getNested(this.entry, this.column.path);
        },
        defaultedComponent() {
            if (this.column.component)
                return Object.assign({ props: ['entry', 'column'] }, this.column.component);
            else
                return null;
        }
    },
    filters: {
        date(value) {
            const date = new Date(value);
            return date.toLocaleDateString();
        },
        datetime(value) {
            const date = new Date(value);
            return date.toLocaleString();
        },
        time(value) {
            const date = new Date(value);
            return date.toLocaleTimeString();
        }
    },
    template: `
        <span>
            <template v-if="column.component">
                <component :is="defaultedComponent" :entry="entry" :column="column"></component>
            </template>
            <template v-else-if="column.type === 'date'">
                {{ value | date }}
            </template>
            <template v-else-if="column.type === 'datetime'">
                {{ value | datetime }}
            </template>
            <template v-else-if="column.type === 'time'">
                {{ value | time }}
            </template>
            <template v-else>
                {{ value }}
            </template>
        </span>
    `
};

export default {
    props: {
        dataUrl: { required: true, type: String },
        columns: { required: true, type: Array },
        options: { type: Object, default: {} }
    },
    data: (props) => ({
        loading: true,
        error: null,
        
        orderBy: props.options && props.options.orderBy 
            ? props.options.orderBy
            : 'id',
        orderType: props.options && props.options.orderType 
            ? props.options.orderType
            : 'asc',
        
        limit: 25,
        search: '',

        page: 1,
        lastPage: 1,
        
        entries: []
    }),
    async mounted() {
        this.fetchEntries();
    },
    computed: {
        defaultedOptions() {
            return deepAssign({
                includeStyle: true,
                displayFooter: true,
                displaySearch: true,
                displayLimit: true,
                displayLoader: true,
                displayPagination: true,
                displayPaginationButtons: true,
                customLoader: null,
                classes: {
                    table: 'table',
                    row: '',
                    level: 'level',
                    levelLeft: 'level-left',
                    levelRight: 'level-right',
                    levelItem: 'level-item',
                    label: 'label is-small',
                    formField: 'field',
                    searchInput: 'input is-small',
                    limitInput: 'select',
                    limitInputContainer: 'select is-small',
                    pagination: 'pagination is-centered is-small',
                    paginationPrevious: 'pagination-previous',
                    paginationNext: 'pagination-next',
                    paginationList: 'pagination-list',
                    paginationLink: 'pagination-link',
                    paginationLinkCurrent: 'is-current',
                    paginationEllipsis: 'pagination-ellipsis'
                },
                labels: {
                    searchLabel: 'Search',
                    searchPlaceholder: 'Search...',
                    limitLabel: 'Limit',
                    loadingLabel: 'Loading...',
                    sortingDesc: '▲',
                    sortingAsc: '▼'
                },
                limits: [5, 10, 25, 50, 100, 500],
                searchKey: ''
            }, this.options);
        },
        pages() {
            return getPaginationArray(this.page, this.lastPage);
        }
    },
    methods: {
        isOrderedBy(column) {
            if (column.component) return;

            return this.orderBy !== column.path 
                ? ''
                : this.orderType === 'desc'
                    ? this.defaultedOptions.labels.sortingDesc
                    : this.defaultedOptions.labels.sortingAsc;
        },
        columnAction(column) {
            if (column.component) return;

            // If we're already ordering by that column, swap type
            if (this.orderBy === column.path) {
                this.orderType = this.orderType === 'asc'
                    ? 'desc'
                    : 'asc';
            } else {
                this.orderBy   = column.path;
                this.orderType = 'asc';
            }

            this.fetchEntries();
        },
        goToPage(pageNumber) {
            if (this.page === pageNumber || pageNumber < 1 || pageNumber > this.lastPage) return;

            this.page = pageNumber;

            this.fetchEntries();
        },
        async fetchEntries() {
            this.loading = true;

            let queryString = '';

            if (this.orderBy !== '') {
                queryString += 'order-by=' + encodeURIComponent(this.orderBy) + '&';
                queryString += 'order-type=' + encodeURIComponent(this.orderType) + '&';
            }

            if (this.limit)
                queryString += 'limit=' + encodeURIComponent(this.limit) + '&';

            if (this.search)
                queryString += 'search=' + encodeURIComponent(this.search) + '&';

            if (this.options.searchKey)
                queryString += 'search-key=' + encodeURIComponent(this.options.searchKey) + '&';

            if (this.page)
                queryString += 'page=' + encodeURIComponent(this.page) + '&';

            try {
                const response = await get(`${this.dataUrl}?${queryString}`);

                const responseData = response.data;
                this.entries       = responseData.data;
                this.lastPage      = responseData.last_page;
                this.error         = null;
                this.loading       = false;
            } catch (e) {
                this.entries   = [];
                this.lastPage = 0;
                this.error     = JSON.stringify(e);
                this.loading   = false;
            }
        },
        refresh() {
            this.fetchEntries();
        }
    },
    watch: {
        search: debounce(function() {
            this.fetchEntries();
        }, 300),
        limit() {
            this.fetchEntries();
        },
        dataUrl() {
            this.error = null;
            this.orderBy = 'id';
            this.orderType = 'asc';
            this.limit = 25;
            this.search = '';
            this.page = 1;
            this.lastPage = 1;
            this.entries = [];

            this.fetchEntries();
        }
    },
    components: {
        'data-display': DataDisplay
    },
    template: `
        <div>
            <div :class="{[defaultedOptions.classes.level]: true}">
                <div :class="{[defaultedOptions.classes.levelLeft]: true}">
                    <div :class="{[defaultedOptions.classes.levelItem]: true}">
                        <div :class="{[defaultedOptions.classes.formField]: true}">
                            <label 
                                for="limit-input"
                                :class="{[defaultedOptions.classes.label]: true}">
                                {{ defaultedOptions.labels.limitLabel }}
                            </label>
                            <div :class="{[defaultedOptions.classes.limitInputContainer]: true}">
                                <select
                                    name="limit-input"
                                    :class="{[defaultedOptions.classes.limitInput]: true}"
                                    v-model="limit"
                                    :disabled="loading">
                                    <option v-for="limit in defaultedOptions.limits" :value="limit">{{ limit }}</option>        
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div :class="{[defaultedOptions.classes.levelItem]: true}" v-if="defaultedOptions.displayLoader">
                    <h3 v-if="!defaultedOptions.customLoader && loading" class="is-size-4">
                        {{ defaultedOptions.labels.loadingLabel }}
                    </h3>
                    <component v-else :is="defaultedOptions.customLoader" :loading="loading"></component>
                </div>

                <div :class="{[defaultedOptions.classes.levelRight]: true}">
                    <div :class="{[defaultedOptions.classes.levelItem]: true}">
                        <div :class="{[defaultedOptions.classes.formField]: true}">
                            <label 
                                for="search-input"
                                :class="{[defaultedOptions.classes.label]: true}">
                                {{ defaultedOptions.labels.searchLabel }}
                            </label>
                            <input 
                                name="search-input" 
                                :placeholder="defaultedOptions.labels.searchPlaceholder" 
                                :class="{[defaultedOptions.classes.searchInput]: true}"
                                :disabled="loading"
                                v-model="search">
                        </div>
                    </div>
                </div>
            </div>
            <table :class="{[defaultedOptions.classes.table]: true, 'smdt__table': true, 'is-loading': loading}">
                <thead>
                    <th 
                        v-for="column in columns" 
                        :key="column.path || column.title" 
                        :class="{[column.headingClass  || '']: true, 'is-sortable': !column.component}"
                        @click="columnAction(column)">
                        {{ column.title ? column.title : column.path }} {{ isOrderedBy(column) }}
                    </th>
                </thead>
                <tbody>
                    <tr v-for="(entry, index) in entries" :class="{[defaultedOptions.classes.row]: true}">
                        <td v-for="column in columns" :key="column.path || column.title" :class="{[column.columnClass || '']: true}">
                            <data-display :entry="entry" :column="column"></data-display>
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="defaultedOptions.displayFooter">
                    <th v-for="column in columns" :key="column.path || column.title" :class="{[column.headingClass || '']: true}">
                        {{ column.title ? column.title : column.path }}
                    </th>
                </tfoot>
            </table>

            <nav aria-label="pagination" :class="{[defaultedOptions.classes.pagination]: true}" role="navigation" v-if="defaultedOptions.displayPagination">
                <a v-if="defaultedOptions.displayPaginationButtons" :disabled="page <= 1" :class="{[defaultedOptions.classes.paginationPrevious]: true}" @click="goToPage(page - 1)">Previous</a>
                <a v-if="defaultedOptions.displayPaginationButtons" :disabled="page >= lastPage" :class="{[defaultedOptions.classes.paginationNext]: true}"  @click="goToPage(page + 1)">Next page</a>
                <ul :class="{[defaultedOptions.classes.paginationList]: true}">
                    <template v-for="pageNumber in pages">
                        <li v-if="pageNumber === '...'">
                            <span :class="{[defaultedOptions.classes.paginationEllipsis]: true}">&hellip;</span>
                        </li>
                        <li v-else>
                            <a 
                                :aria-label="'Goto page ' + pageNumber" 
                                :class="{[defaultedOptions.classes.paginationLink]: true, [defaultedOptions.classes.paginationLinkCurrent]: page === pageNumber}"
                                @click="goToPage(pageNumber)"
                                :disabled="page === pageNumber">
                                {{ pageNumber }}
                            </a>
                        </li>
                    </template>
                </ul>
            </nav>
            
        </div>
    `
};