<template>
	<div class="top_bar">
		<div class="top_bar_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
							<ul class="top_bar_contact_list">
								<li><div class="question">¿Tienes alguna duda?</div></li>
                <li>
                  <i class="f005" aria-hidden="true"></i>
                  <div>{{phone}}</div>
                </li>
                <li>
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                  <div>{{email}}</div>
                </li>
              </ul>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
</template>

<script>
export default {
  name: 'Topbar',
  data: () => {
    return {
      phone: '41 997138892',
      email: 'tom@eadtools.com'
    }
  },
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
