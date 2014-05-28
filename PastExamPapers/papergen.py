import os

APP_DIR = os.path.dirname(__file__)
DATA_DIR = os.path.join(APP_DIR, 'static/papers')


class Tab:
    def __init__(self, tab_dir):
        self.name = tab_dir.split('/')[-1]
        courses = []
        for course_name in os.listdir(tab_dir):
            course_dir = os.path.join(tab_dir, course_name)
            if os.path.isdir(course_dir):
                courses.append(Course(course_dir))
        self.courses = courses


class Course:
    def __init__(self, course_dir):
        self.name = course_dir.split('/')[-1]
        papers = []
        for paper_name in os.listdir(course_dir):
            paper_dir = os.path.join(course_dir, paper_name)
            papers.append(Paper(paper_dir))
        self.papers = papers


class Paper:
    def __init__(self, paper_dir):
        self.name = paper_dir.split('/')[-1]
        self.url = paper_dir

    @property
    def noSuffixName(self):
        return os.path.splitext(self.name)[0]


def getTabs():
    tabs = []
    for tab_name in os.listdir(DATA_DIR):
        tab_dir = os.path.join(DATA_DIR, tab_name)
        if os.path.isdir(tab_dir):
            tabs.append(Tab(tab_dir))
    return tabs
