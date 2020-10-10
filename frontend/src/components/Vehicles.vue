<template>
    <div id="vehicles" style="width: 100%; margin: 10px">
        <div style="width: 68%; float: left">
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
        <div
            style="margin-left: 70%; padding: 10px; border-left: 5px solid red"
        >
            <h1>Vehicle Form Input</h1>
            <form>
                <label for="name">Vehicle Name:</label>
                <input type="text" v-model="form.name" />
                <br />

                <label for="engine_displacement">Engine Displacement:</label>
                <input type="text" v-model="form.engine_displacement" />
                <select v-model="form.engine_displacement_unit">
                    <option v-for="unit in units" :key="unit.id">
                        {{ unit }}
                    </option>
                </select>
                <br />

                <label for="price">Price:</label>
                <input type="text" v-model="form.price" />
                <br />

                <label for="location">Location:</label>
                <input type="text" v-model="form.location" />
                <br />

                <button type="button" id="submit" v-on:click="store">
                    Submit
                </button>
            </form>
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
                .put("http://localhost:8000/")
                .then((response) => {
                    this.lists = response.data.data;
                })
                .catch(function (error) {
                    alert(error);
                });
        },
        store: function () {
            if (this.form.name == "") {
                alert("Vehicle Name is required");
                return;
            }
            if (this.form.engine_displacement == "") {
                alert("Engine Displacement is required");
                return;
            } else if (isNaN(this.form.engine_displacement)) {
                alert("Engine Displacement must be number");
                return;
            }
            if (this.form.engine_displacement_unit == "") {
                alert("Engine Displacement Unit is required");
                return;
            }
            if (this.form.price != "" && isNaN(this.form.price)) {
                alert("Price must be number");
                return;
            }

            var formdata = new FormData();
            formdata.append("name", this.form.name);
            formdata.append(
                "engine_displacement",
                this.form.engine_displacement
            );
            formdata.append(
                "engine_displacement_unit",
                this.form.engine_displacement_unit
            );
            formdata.append("price", this.form.price);
            formdata.append("location", this.form.location);

            axios
                .post("http://localhost:8000/", formdata)
                .then((response) => {
                    if (response.data.success) {
                        this.form.name = "";
                        this.form.engine_displacement = "";
                        this.form.engine_displacement_unit = this.units[0];
                        this.form.price = "";
                        this.form.location = "";

                        this.loadList();
                    }
                    alert(response.data.message);
                })
                .catch(function (error) {
                    alert(error);
                });
        },
        loadList: function () {
            axios
                .get("http://localhost:8000/", {
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
    created() {
        if (this.units.length > 0) {
            this.form.engine_displacement_unit = this.units[0];
        }
    },
};
</script>

<style scoped>
#TableList {
    width: 100%;
}
table,
th,
td {
    border: 1px solid black;
    padding: 6px;
}
table {
    border: 1px solid #656565;
    border-radius: 10px;
    -moz-border-radius: 10px;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 10px 10px 5px #888888;
    width: 100%;
    margin-bottom: 15px;
    border-spacing: 0;
}
table thead tr th {
    background-color: lightgray;
}
table thead tr th:first-child {
    z-index: -1;
    border-radius: 10px 0 0 0;
    -moz-border-radius: 10px 0 0 0;
    border-radius: 10px 0 0 0;
}
table thead tr th:last-child {
    z-index: -1;
    border-radius: 0 10px 0 0;
    -moz-border-radius: 0 10px 0 0;
    border-radius: 0 10px 0 0;
}
#submit {
    width: 99%;
    margin-top: 10px;
    padding: 10px;
    border-radius: 4px;
    display: block;
}
label {
    display: block;
    margin: 10px;
}
input {
    font-size: 30px;
    border: 1px double rgb(102, 97, 96);
    border-radius: 4px;
}
select {
    width: 99%;
    font-size: 15px;
    border: 1px double rgb(102, 97, 96);
    border-radius: 4px;
}
a {
    color: #000000;
    text-decoration: none;
}
</style>
