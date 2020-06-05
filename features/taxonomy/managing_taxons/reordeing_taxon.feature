@managing_taxons
Feature: Reordering taxons
    In order to see all ordered taxons in the list
    As an Administrator
    I want to browse ordered taxons

    Background:
         Given pets are classified under "Cats" and "Dogs" categories
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Moving up the taxon on the list
        When I want to see all taxons in the list
        And I move up "Dogs" taxon
        Then I should see 2 taxons on the list
        And I should see the taxon named "Cats" in the list
        But the first taxon on the list should be "Dogs"

    @ui @javascript
    Scenario: Moving down the taxon on the list
        When I want to see all taxons in the list
        And I move down "Cats" taxon
        Then I should see 2 taxons on the list
        And I should see the taxon named "Cats" in the list
        But the first taxon on the list should be "Dogs"
