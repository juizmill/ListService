Git branching workflow
======================

Try to follow the steps below:

- Fork a repository and clone it:

```
	$ cd ~ /Dev/ListService
	$ Git clone -b develop git@github.com:YOURUSER/ListService.git
```

- Added the remote repository:

```
	$ git remote add uplistservice git@github.com:juizmill/ListService.git
```

- Create your branch:

	By default must start with the ISSUE + issue number where u will work, for example issue-1


```
	$ git checkout -b issue-X
	$ git push origin issue-X
```

- Before making any changes you should update your local repository:

```
	$ git fetch uplistservice
	$ git checkout issue-X
	$ git rebase uplistservice/develop
```

- If you need to force sending to your branch:

```
	$ git push -f origin issue-X
```

- When your PR gets merged into at develop, update your working copy:

```
	$ git fetch uplistservice
	$ git checkout develop
	$ git merge uplistservice/develop
	$ git push origin develop
```

TODO
----

If any conflict is programmer's responsibility to remove the conflict.
