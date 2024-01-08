export const state = () => ({
  loading: false,
  login: "",
  role: ""
});

export const mutations = {
  login(state, res) {
    if (res && res.result) {
      state.login = res.result.name;
      state.role = res.result.role;
    }
  },
  logout(state) {
    state.login = false;
    state.role = false;
  }
};

export const actions = {};
