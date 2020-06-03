@managing_taxons
Feature: Browsing taxons
    In order to see all taxons in the list
    As an Administrator
    I want to browse taxons

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And I am logged in as an administrator

    @ui
    Scenario: Browsing taxons in the list
        Given I want to see all taxons in the list
        Then I should see 2 taxons on the list
        And I should see the taxon named "Cats" in the list
