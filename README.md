TIM QA environment  Openfire configuration
===

Description
---

1. Each project has an configuration project in gitlab

2. Configuration of different S/W service are put int different branch by name conf/<service_name>.

3. The container of each configuration enabled S/W service
    - equipped with git commands
    - setup with
        - git repo URL(CONF_REPO_URL)
        - branch name(CONF_BRANCH) of the configuration git project of the S/W service
        - commit point(CONF_COMMIT_ID) informs of commit id in SHA256 that service targeted to.
    - each time the container of S/W service brought up, it must
        - checkout the branch and switch to commit point.
            - If the configuration project(assigned by CONF_REPO_URL) not existed (first startup), clone the project by internet (Internet needed at this moment).
            - If the assigned commit point not existed, update the project by git pull
        - replace existed configurations with configuration assigned by CONF_REPO_URL,CONF_BRANCH,CONF_COMMIT_ID.
        - If the configuration assigned by CONF_COMMIT_ID is unreachable, the service should SHUTDOWN AND SHOW ERROR TO CONTAINER CONSOLE.