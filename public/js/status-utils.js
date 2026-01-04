/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/status-utils.js ***!
  \**************************************/
/**
 * Status Badge Utility Functions
 * Provides consistent status badge generation across the application
 *
 * USAGE EXAMPLES:
 *
 * 1. In Alpine.js components:
 *    <div x-html="window.StatusUtils.generateBadge('Pending', 'base')"></div>
 *
 * 2. In JavaScript:
 *    const badgeHtml = window.StatusUtils.generateBadge('Confirmed', 'sm');
 *
 * 3. In Blade templates:
 *    <x-status-badge status="Pending" size="base" />
 *
 * 4. Get just the colors:
 *    const colors = window.StatusUtils.getStatusColors('Processing');
 *    // Returns: { bg: 'bg-[#F3EFFF]', text: 'text-[#A259FF]' }
 */

window.StatusUtils = {
  /**
   * Get status configuration for badges
   */
  getStatusConfig: function getStatusConfig() {
    return {
      Pending: {
        bg: "bg-[#FFF4E0]",
        text: "text-[#FFB800]",
        label: "Pending"
      },
      Partial: {
        bg: "bg-[#FFF4E0]",
        text: "text-[#FFB800]",
        label: "Partial"
      },
      Confirmed: {
        bg: "bg-[#E8F5E8]",
        text: "text-[#28A745]",
        label: "Confirmed"
      },
      Completed: {
        bg: "bg-[#E3F2FD]",
        text: "text-[#2196F3]",
        label: "Completed"
      },
      Cancelled: {
        bg: "bg-[#FFEBEE]",
        text: "text-[#F44336]",
        label: "Cancelled"
      },
      Processing: {
        bg: "bg-[#F3EFFF]",
        text: "text-[#A259FF]",
        label: "Processing"
      },
      "Processing on Branch": {
        bg: "bg-[#F3EFFF]",
        text: "text-[#A259FF]",
        label: "Processing on Branch"
      },
      "Pending for Staff": {
        bg: "bg-[#F3EFFF]",
        text: "text-[#A259FF]",
        label: "Pending for Staff"
      },
      "Pending for Branch": {
        bg: "bg-[#F3EFFF]",
        text: "text-[#A259FF]",
        label: "Pending for Branch"
      },
      Paid: {
        bg: "bg-[#E8F5E8]",
        text: "text-[#28A745]",
        label: "Paid"
      },
      Unpaid: {
        bg: "bg-[#FFEAEA]",
        text: "text-[#EC2028]",
        label: "Unpaid"
      },
      "Not Paid": {
        bg: "bg-[#EC20281A]",
        text: "text-[#EC2028]",
        label: "Not Paid"
      },
      Overdue: {
        bg: "bg-[#FFF3E0]",
        text: "text-[#FF9800]",
        label: "Overdue"
      }
    };
  },
  /**
   * Get size classes for different badge sizes
   */
  getSizeClasses: function getSizeClasses() {
    return {
      xs: "text-xs px-2 py-1",
      sm: "text-sm px-2 py-1",
      base: "text-base px-3 py-1",
      lg: "text-lg px-4 py-2"
    };
  },
  /**
   * Generate status badge HTML
   * @param {string} status - The status value
   * @param {string} size - The badge size (xs, sm, base, lg)
   * @returns {string} HTML string for the badge
   */
  generateBadge: function generateBadge(status) {
    var size = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "base";
    var statusConfig = this.getStatusConfig();
    var sizeClasses = this.getSizeClasses();
    var config = statusConfig[status] || {
      bg: "bg-gray-100",
      text: "text-gray-600",
      label: status
    };
    return "<span class=\"rounded-lg font-normal whitespace-nowrap overflow-hidden text-ellipsis max-w-full ".concat(config.bg, " ").concat(config.text, " ").concat(sizeClasses[size], "\">").concat(config.label, "</span>");
  },
  /**
   * Get status color classes for use in other components
   * @param {string} status - The status value
   * @returns {object} Object with bg and text classes
   */
  getStatusColors: function getStatusColors(status) {
    var statusConfig = this.getStatusConfig();
    return statusConfig[status] || {
      bg: "bg-gray-100",
      text: "text-gray-600"
    };
  }
};
/******/ })()
;