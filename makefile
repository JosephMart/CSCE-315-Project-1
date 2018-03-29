PY = python3
VENV_PATH = arduino/venv
.PHONY: init_venv deps freeze clean_venv

all: init_venv deps
	PYTHONPATH=$(VENV_PATH) ; . $(VENV_PATH)/bin/activate

init_venv:
	if [ ! -e "$(VENV_PATH)/bin/activate.py" ] ; then PYTHONPATH=$(VENV_PATH) ; fi

deps:
	PYTHONPATH=$(VENV_PATH) ; . $(VENV_PATH)/bin/activate && $(VENV_PATH)/bin/pip install -U -r arduino/requirements.txt && if [ "$(ls arduino/requirements)" ] ; then $(VENV_PATH)/bin/pip install -U -r arduino/requirements/* ; fi

freeze:
	. $(VENV_PATH)/bin/activate && $(VENV_PATH)/bin/pip freeze > arduino/requirements.txt

move:
	rm -rf ~/web_project/p1;mkdir ~/web_project/p1;
	cp -r ~/315Project1/server/* ~/web_project/p1/

clean_venv:
	rm -rf $(VENV_PATH)

run:
	. $(VENV_PATH)/bin/activate && $(PY) arduino/main.py

test_python:
	. $(VENV_PATH)/bin/activate && $(PY) arduino/tests/TestApi.py

deploy:
	scripts/deploy.sh "./server/*"
