const alerts = {
  methods: {
    $errorMessage() {
      this.$message({
        title: this.lang.error,
        message: this.lang['error-callback-message'],
        type: 'error',
        duration: 2000
      });
    },
    $successMessage() {
      this.$message({
        title: this.lang.success,
        message: this.lang['success-callback-message'],
        type: 'success',
        duration: 2000
      });
    },
    $unansweredQuestion() {
      this.$message({
        message: this.lang['unanswered-question'],
        type: 'error'
      });
    },
    $diferentPasswords() {
      this.$message({
        message: this.lang['invalid-confirm-password'],
        type: 'error'
      });
    },
    $userAlreadyExists() {
      this.$message({
        message: this.lang['user-already-exists'],
        type: 'error'
      });
    }
  }
};

export default alerts;
