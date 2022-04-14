@admin_dashboard
Feature: Statistics dashboard
    In order to have an overview of my database
    As an Administrator
    I want to see overall statistics on my admin dashboard

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Seeing statistics
        Given there are 9 customers
        When I open administration dashboard
        Then I should see 9 new customers

    @ui
    Scenario: Seeing recent customers
        Given there are 4 customers
        When I open administration dashboard
        Then I should see 4 new customers in the list

    @ui
    Scenario: Seeing pet statistics
        Given there are 3 pets
        When I open administration dashboard
        Then I should see 3 new pets

    @ui
    Scenario: Seeing recent pets
        Given there are 4 pets
        When I open administration dashboard
        Then I should see 4 new pets in the list

    @ui @todo
    Scenario: Seeing booking statistics
        Given there are 3 pets
        And there are 2 customers
        And there are 2 bookings
        When I open administration dashboard
        Then I should see 2 new bookings

    @ui @todo
    Scenario: Seeing recent bookings
        Given there are 3 pets
        And there are 2 customers
        And there are 2 bookings
        When I open administration dashboard
        Then I should see 2 new bookings in the list
