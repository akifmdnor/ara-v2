/**
 * Date and Time Picker with Availability Restrictions
 * Handles date selection, time restrictions, and availability logic
 */

class DateTimePicker {
    constructor() {
        this.restrictedDates = [];
        this.now = new Date();
        this.needToUpdateTime = false;
        this.initializeDateTimePicker();
    }

    /**
     * Initialize the date and time picker functionality
     */
    initializeDateTimePicker() {
        this.setupInitialDates();
        this.fetchRestrictedDates();
        this.setupDatePickers();
        this.setupTimeRestrictions();
    }

    /**
     * Setup initial dates based on current time
     */
    setupInitialDates() {
        // If current time is after 7 PM, set start date to day after tomorrow
        if (this.now.getHours() >= 19) {
            this.now.setDate(this.now.getDate() + 2);
            this.now.setHours(9, 0, 0, 0);
            this.needToUpdateTime = true;
        } else {
            // If before 7 PM, set start date to tomorrow
            this.now.setDate(this.now.getDate() + 1);
            this.now.setHours(9, 0, 0, 0);
        }

        // Check if URL has time parameters
        const urlParams = new URLSearchParams(window.location.search);
        const hasPickupTime = urlParams.has("pickup_time");
        const hasReturnTime = urlParams.has("return_time");

        if (!hasPickupTime && !hasReturnTime) {
            this.needToUpdateTime = true;
        }

        // Set initial dates
        this.setDateInput(
            this.getDateString(this.now, 0),
            this.getDateString(this.now, 1)
        );
    }

    /**
     * Fetch restricted dates from server
     */
    async fetchRestrictedDates() {
        try {
            const response = await fetch("/restricted-date");
            const data = await response.json();
            this.restrictedDates = this.restrictedDates.concat(data);

            // Sort restricted dates
            this.restrictedDates.sort((a, b) => {
                const aa = a.split("-").reverse().join();
                const bb = b.split("-").reverse().join();
                return aa < bb ? -1 : aa > bb ? 1 : 0;
            });

            this.processRestrictedDates();
        } catch (error) {
            console.error("Error fetching restricted dates:", error);
        }
    }

    /**
     * Process restricted dates and update pickers
     */
    processRestrictedDates() {
        let nextAvailableDate = this.getDateString(this.now, 0);

        // Check if next available date is restricted
        this.restrictedDates.forEach((date) => {
            if (nextAvailableDate === date) {
                this.now.setDate(this.now.getDate() + 1);
                this.now.setHours(1, 0, 0, 0);
                nextAvailableDate = this.getDateString(this.now, 0);
                this.needToUpdateTime = true;
            }
        });

        // Update date pickers with restricted dates
        this.updateDatePickers();

        // Update time restrictions if needed
        if (this.needToUpdateTime) {
            this.updateAvailableTimes(this.now, this.now);
            this.needToUpdateTime = false;
        }
    }

    /**
     * Setup date pickers with restrictions
     */
    setupDatePickers() {
        console.log("Setting up date pickers...");

        // Start Date Picker
        if ($("#InputStartDate").length) {
            $("#InputStartDate")
                .datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    startDate: "+1d",
                    endDate: "+1y",
                    datesDisabled: this.restrictedDates,
                    todayHighlight: false,
                    clearBtn: true,
                    orientation: "bottom auto",
                    beforeShowDay: (date) => {
                        // Disable today and past dates
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        return [date >= today, ""];
                    },
                })
                .on("changeDate", (selected) => {
                    console.log("Start date changed:", selected.date);
                    this.onStartDateChange(selected);
                });
            console.log("Start date picker initialized");
        } else {
            console.error("InputStartDate element not found");
        }

        // Return Date Picker
        if ($("#InputReturnDate").length) {
            $("#InputReturnDate").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                startDate: "+0d",
                todayHighlight: true,
                clearBtn: true,
                orientation: "bottom auto",
            });
            console.log("Return date picker initialized");
        } else {
            console.error("InputReturnDate element not found");
        }
    }

    /**
     * Handle start date change
     */
    onStartDateChange(selected) {
        const minDate = new Date(selected.date.valueOf());
        minDate.setDate(minDate.getDate() + 1);

        // Update return date picker
        $("#InputReturnDate").datepicker("setStartDate", minDate);

        // Set return date to one day after start date
        const year = minDate.getFullYear();
        const month = String(minDate.getMonth() + 1).padStart(2, "0");
        const day = String(minDate.getDate()).padStart(2, "0");
        $("#InputReturnDate").val(`${day}-${month}-${year}`);

        // Update available times
        selected.date.setHours(
            this.now.getHours(),
            this.now.getMinutes(),
            this.now.getSeconds(),
            this.now.getMilliseconds()
        );
        this.updateAvailableTimes(selected.date, this.now);
    }

    /**
     * Update date pickers with restricted dates
     */
    updateDatePickers() {
        // Ensure start date is always at least tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(0, 0, 0, 0);

        const startDate = this.now > tomorrow ? this.now : tomorrow;

        $("#InputStartDate").datepicker(
            "setDatesDisabled",
            this.restrictedDates
        );
        $("#InputReturnDate").datepicker(
            "setDatesDisabled",
            this.restrictedDates.concat(this.getDateString(this.now, 0))
        );
        $("#InputStartDate").datepicker("setStartDate", startDate);
        $("#InputReturnDate").datepicker(
            "setStartDate",
            this.getDateString(startDate, 1)
        );

        this.setDateInput(
            this.getDateString(startDate, 0),
            this.getDateString(startDate, 1)
        );
    }

    /**
     * Update available times based on selected date
     */
    updateAvailableTimes(date, today) {
        const currentDateTime = new Date(date);
        const currentHours = currentDateTime.getHours();
        const currentMinutes = currentDateTime.getMinutes();
        const currentDay = currentDateTime.getDate();
        const todayDay = today.getDate();

        // Only apply time restrictions if the selected date is today
        if (currentDay === todayDay) {
            console.log(`currentDay: ${currentDay}, today: ${todayDay}`);

            let firstAvailableOption = null;

            $("#InputStartTime option").each(function () {
                const optionTime = $(this).val().toUpperCase();
                const optionDateTime = new Date("01/01/2007 " + optionTime);

                // Check if current time is before 9 AM
                if (currentHours < 9) {
                    if (
                        optionDateTime.getHours() < 10 ||
                        (optionDateTime.getHours() === 10 &&
                            optionDateTime.getMinutes() < 30)
                    ) {
                        $(this).prop("disabled", true);
                    }
                } else {
                    // Disable time options less than one hour from now
                    const currentTimeInMinutes =
                        currentHours * 60 + currentMinutes;
                    const optionTimeInMinutes =
                        optionDateTime.getHours() * 60 +
                        optionDateTime.getMinutes();

                    if (optionTimeInMinutes <= currentTimeInMinutes + 60) {
                        $(this).prop("disabled", true);
                    } else if (!firstAvailableOption) {
                        firstAvailableOption = this;
                    }
                }

                // If currently selected option is disabled, select next available
                if ($(this).is(":selected") && $(this).is(":disabled")) {
                    $(this).prop("selected", false);
                    if (firstAvailableOption) {
                        $(firstAvailableOption).prop("selected", true);
                    }
                }
            });
        } else {
            // Enable all time options for future dates
            $("#InputStartTime option").each(function () {
                $(this).prop("disabled", false);
            });
        }
    }

    /**
     * Setup time restrictions
     */
    setupTimeRestrictions() {
        if (this.needToUpdateTime) {
            this.updateAvailableTimes(this.now, this.now);
            this.needToUpdateTime = false;
        }
    }

    /**
     * Get date string in dd-mm-yyyy format
     */
    getDateString(now, dateToAdd) {
        const tempNow = new Date(now);
        tempNow.setDate(tempNow.getDate() + dateToAdd);

        const month = String(tempNow.getMonth() + 1).padStart(2, "0");
        const day = String(tempNow.getDate()).padStart(2, "0");

        return `${day}-${month}-${tempNow.getFullYear()}`;
    }

    /**
     * Set date input values with validation
     */
    setDateInput(startDate, returnDate) {
        const startDateInput = $("#InputStartDate")
            .val()
            .split("-")
            .reverse()
            .join("");
        const returnDateInput = $("#InputReturnDate")
            .val()
            .split("-")
            .reverse()
            .join("");
        const startDateConv = startDate.split("-").reverse().join("");
        const returnDateConv = returnDate.split("-").reverse().join("");

        // Set to minimum date if input is earlier
        if (startDateInput < startDateConv) {
            $("#InputStartDate").val(startDate);
        }

        if (returnDateInput < returnDateConv) {
            $("#InputReturnDate").val(returnDate);
        }
    }

    /**
     * Update blocked dates
     */
    updateBlockDate(dateArray) {
        $("#InputStartDate").datepicker("setDatesDisabled", dateArray);
        $("#InputReturnDate").datepicker("setDatesDisabled", dateArray);
    }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    // Wait for jQuery and datepicker to be available
    if (typeof $ !== "undefined" && $.fn.datepicker) {
        window.dateTimePicker = new DateTimePicker();
    } else {
        // Fallback: wait a bit more for scripts to load
        setTimeout(function () {
            if (typeof $ !== "undefined" && $.fn.datepicker) {
                window.dateTimePicker = new DateTimePicker();
            } else {
                console.error("jQuery or Bootstrap Datepicker not loaded");
            }
        }, 1000);
    }
});
