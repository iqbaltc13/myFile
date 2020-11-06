<template>
	<div id="sc-page-wrapper">
		<div id="sc-page-content">
			<div class="uk-child-width-1-2@m uk-grid" data-uk-grid>
				<div>
					<ScCard>
						<ScCardTitle>
							Default
						</ScCardTitle>
						<ScCardBody>
							<DateRangePicker>
								<ScInput v-model="drpDefault" placeholder="Pick a range..."></ScInput>
							</DateRangePicker>
						</ScCardBody>
					</ScCard>
				</div>
				<div>
					<ScCard>
						<ScCardTitle>
							Time Enabled
						</ScCardTitle>
						<ScCardBody>
							<DateRangePicker :config="{format: 'DD.MM.YYYY HH:mm', autoClose: false, time: { enabled: true }}">
								<ScInput v-model="drpTime" placeholder="Pick a range..."></ScInput>
							</DateRangePicker>
						</ScCardBody>
					</ScCard>
				</div>
				<div>
					<ScCard>
						<ScCardTitle>
							Future date shortcuts
						</ScCardTitle>
						<ScCardBody>
							<DateRangePicker :config="{showShortcuts: true, shortcuts: {'next-days': [3, 5, 7], 'next': ['week', 'month', 'year']}}">
								<ScInput v-model="drpFutureDates" placeholder="Pick a range..."></ScInput>
							</DateRangePicker>
						</ScCardBody>
					</ScCard>
				</div>
				<div>
					<ScCard>
						<ScCardTitle>
							Extra content
						</ScCardTitle>
						<ScCardBody>
							<DateRangePicker :config="drpExtraContent">
								<ScInput v-model="drpExtraContentVal" placeholder="Pick a range..."></ScInput>
							</DateRangePicker>
						</ScCardBody>
					</ScCard>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import ScInput from '~/components/Input'
import DateRangePicker from '~/components/DateRangePicker'

export default {
	components: {
		ScInput,
		DateRangePicker
	},
	data: () => ({
		drpDefault: '',
		drpTime: '',
		drpFutureDates: '',
		drpExtraContentVal: ''
	}),
	computed: {
		drpExtraContent () {
			return {
				showDateFilter (time, date) {
					return '<span class="sc-text-semibold">' + date + '</span>' +
						'<div class="sc-color-secondary uk-margin-mini-top">$' + Math.round(Math.random() * 999) + '</div>';
				}
			}
		}
	}
}
</script>
