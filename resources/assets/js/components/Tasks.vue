<template>
  <div>
    <div v-if="userState.authenticated">
      <p class="text-center"><strong>Hello, {{ userState.user.name }}!</strong></p>

      <div class="contents-wrapper">

        <div class="new-task">
          <div class="new-task-input">
            <input type="text" class="form-control" v-model="name" placeholder="New Task">
          </div>
          <div class="new-task-btn">
            <button class="btn btn-primary" disabled="disabled" v-if="name === ''">
              Add task
            </button>
            <button class="btn btn-primary" @click='addTask' v-else>
              Add task
            </button>
          </div>
        </div>

        <ul class="todo-list">
          <li v-for="task in tasks" :key="task.id" :class="{editing: task == editedTask}">
            <div class="view">
              <p v-if="task.is_done"><strike> {{ task.name }} </strike></p>
              <p v-else><label @dblclick="editTask(task)" title="Double click to Edit">{{ task.name }}</label></p>
                   
              <button @click="completeTask(task)" class="btn btn-sm btn-success" v-if="task.is_done">Undo</button>
              <button @click="completeTask(task)" class="btn btn-sm btn-success" v-else>Done</button>

              <button @click="removeTask(task)" class="btn btn-sm btn-danger">Remove</button>
            </div>
            <input class="edit form-control" type="text" v-model="task.name" v-task-focus="task == editedTask" @blur="doneEdit(task)" @keyup.enter="doneEdit(task)" @keyup.esc="cancelEdit(task)">
          </li>
        </ul>
      </div>

      <p class="text-center"><a @click="logout()">Log out</a></p>
    </div>

    <p v-else>
      please <router-link to="/login">sign in.</router-link>
    </p>
  </div>
</template>
<script>
  import http from '../services/http'
  import userStore from '../stores/userStore'

  export default {
    mounted() {
      this.fetchTasks()
    },

    data() {
      return {
        tasks: [],
        name: '',
        editedTask: null,
        userState: userStore.state
      }
    },

    methods: {
      fetchTasks () {
        http.get('tasks', res => {
          this.tasks = res.data;
        });
      },

      addTask () {
        http.post('tasks', {name: this.name}, res => {
          this.tasks.unshift(res.data); 
        });
      },

      completeTask (task) {
        http.put('tasks/' + task.id, {is_done: !task.is_done}, res => {
          var index = this.tasks.findIndex(function(currentTask){
             return task.id == currentTask.id;
          });
          this.tasks.splice(index, 1, res.data);
        });
      },

      removeTask (task) {
        http.delete('tasks/' + task.id, {}, () => {
          this.tasks = this.tasks.filter(function(currentTask){
            return task.id !== currentTask.id;
          });
        });
      },

      editTask (task) {
        this.beforeEditCache = task.name;
        this.editedTask = task;
      },

      doneEdit (task) {
        if (!this.editedTask) {
          return;
        }
        this.editedTask = null;
        task.name = task.name.trim();

        http.put('tasks/' + task.id, {name: task.name}, res => {
          var index = this.tasks.findIndex(function(currentTask){
             return task.id == currentTask.id;
          });
          this.tasks.splice(index, 1, res.data);
        });

        if (!task.name) {
          this.removeTask(task);
        }
      },

      cancelEdit (task) {
        this.editedTask = null;
        task.name = this.beforeEditCache;
      },

      logout() {
        userStore.logout( () => {
          this.$router.push('/login')
        })
      }
    },

    directives: {
      'task-focus': function (el, binding) {
        if (binding.value) {
          el.focus();
        }
      }
    }
  }
</script>