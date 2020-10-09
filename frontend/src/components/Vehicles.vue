<template>
    <div id="vehicles" style="width: 100%; margin: 10px">
        <div>
            <h1>List Registered Vehicles</h1>
            <button
                type="button"
                style="
                    padding-top: 10px;
                    padding-bottom: 10px;
                    padding-left: 25px;
                    padding-right: 25px;
                    background-color: red;
                    border-radius: 9px;
                "
                v-on:click="reset"
            >
                Reset
            </button>
            <table>
                <thead>
                    <tr style="background: lightgray">
                        <th width="5%">ID</th>
                        <th>
                            <a href="#" v-on:click="sortby('name')">
                                Name
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_asc"
                                    v-if="
                                        this.sort.column == 'name' &&
                                        this.sort.sortby == 'asc'
                                    "
                                />
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_desc"
                                    v-if="
                                        this.sort.column == 'name' &&
                                        this.sort.sortby == 'desc'
                                    "
                                />
                            </a>
                        </th>
                        <th width="15%">
                            <a
                                href="#"
                                v-on:click="sortby('engine_displacement')"
                            >
                                Engine Displacement
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_asc"
                                    v-if="
                                        this.sort.column ==
                                            'engine_displacement' &&
                                        this.sort.sortby == 'asc'
                                    "
                                />
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_desc"
                                    v-if="
                                        this.sort.column ==
                                            'engine_displacement' &&
                                        this.sort.sortby == 'desc'
                                    "
                                />
                            </a>
                        </th>
                        <th width="15%">
                            <a href="#" v-on:click="sortby('engine_power')">
                                Engine Power
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_asc"
                                    v-if="
                                        this.sort.column == 'engine_power' &&
                                        this.sort.sortby == 'asc'
                                    "
                                />
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_desc"
                                    v-if="
                                        this.sort.column == 'engine_power' &&
                                        this.sort.sortby == 'desc'
                                    "
                                />
                            </a>
                        </th>
                        <th width="15%">
                            <a href="#" v-on:click="sortby('price')">
                                Price
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_asc"
                                    v-if="
                                        this.sort.column == 'price' &&
                                        this.sort.sortby == 'asc'
                                    "
                                />
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_desc"
                                    v-if="
                                        this.sort.column == 'price' &&
                                        this.sort.sortby == 'desc'
                                    "
                                />
                            </a>
                        </th>
                        <th>
                            <a href="#" v-on:click="sortby('location')">
                                Location
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_asc"
                                    v-if="
                                        this.sort.column == 'location' &&
                                        this.sort.sortby == 'asc'
                                    "
                                />
                                <img
                                    width="10px"
                                    height="10px"
                                    v-bind:src="sort_desc"
                                    v-if="
                                        this.sort.column == 'location' &&
                                        this.sort.sortby == 'desc'
                                    "
                                />
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in lists" :key="list.id">
                        <td style="text-align: right">{{ index + 1 }}</td>
                        <td style="text-align: left">{{ list.name }}</td>
                        <td style="text-align: right">
                            {{ list.engine_displacement }}
                        </td>
                        <td style="text-align: right">
                            {{ list.engine_power }}
                        </td>
                        <td style="text-align: right">{{ list.price }}</td>
                        <td style="text-align: left">{{ list.location }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import sortdown from "../assets/sort_down.png";
import sortup from "../assets/sort_up.png";

export default {
    name: "vehicles",
    data() {
        return {
            form: {
                name: "",
                engine_displacement: "",
                engine_displacement_unit: "",
                price: "",
                location: "",
            },
            units: ["liter", "cc", "ci"],
            sort: {},
            lists: [],
            sort_desc: sortdown,
            sort_asc: sortup,
        };
    },
    methods: {
        reset: function () {
            axios
                .get("http://localhost/WebProjects/UCC-Test/backend/reset")
                .then((response) => {
                    this.lists = response.data.data;
                })
                .catch(function (error) {
                    alert(error);
                });
        },
        loadList: function () {
            axios
                .get("http://localhost/WebProjects/UCC-Test/backend/", {
                    params: {
                        column: this.sort.column,
                        sortby: this.sort.sortby,
                    },
                })
                .then((response) => {
                    this.lists = response.data.data;
                })
                .catch(function (error) {
                    alert(error);
                });
        },
        sortby: function (column) {
            this.sort = {
                column: column,
                sortby:
                    this.sort.column == column && this.sort.sortby == "asc"
                        ? "desc"
                        : "asc",
            };
            this.loadList();
        },
    },
    mounted() {
        this.loadList();
    },
};
</script>

<style scoped>
</style>
