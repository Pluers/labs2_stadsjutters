<template>
    <div id="admin">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin page!</p>
        <div>
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.first_name }}</td>
                        <td>{{ user.last_name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            <button @click="editUser(user.id)">Edit</button>
                            <button @click="deleteUser(user.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h2>Manage Posts</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Condition</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts" :key="post.id">
                        <td>{{ post.id }}</td>
                        <td>{{ post.title }}</td>
                        <td>{{ post.body }}</td>
                        <td>{{ post.condition }}</td>
                        <td>{{ post.user.first_name }}</td>
                        <td>{{ post.user.last_name }}</td>
                        <td>
                            <button @click="editPost(post.id)">Edit</button>
                            <button @click="deletePost(post.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Add more sections as needed -->
    </div>
</template>
<script>
import axios from 'axios';
//TODO: Add the delete and edit methods
export default {
    data() {
        return {
            users: [],
            posts: []
        };
    },
    async created() {
        try {
            const usersResponse = await axios.get('/api/user/getall');
            this.users = usersResponse.data;

            const postsResponse = await axios.get('/api/post/getall');
            if (postsResponse.status === 200) {
                this.posts = postsResponse.data.map(post => {
                    const user = this.users.find(user => user.id === post.user_id);
                    return {
                        ...post,
                        user: user ? user : null
                    };
                }).sort((a, b) => new Date(b.created_on) - new Date(a.created_on));
            }
        } catch (error) {
            console.error(error);
        }
    },
};
</script>