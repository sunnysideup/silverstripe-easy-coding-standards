#!/usr/bin/env bash
set -euo pipefail

############################################ BASICS
SCRIPT_DIR="${COMPOSER_RUNTIME_BIN_DIR:?COMPOSER_RUNTIME_BIN_DIR not set}"
WORKING_DIR=$(pwd)
source "$SCRIPT_DIR/sake-self-methods"
SCRIPT_SUMMARY="Adds a user as a collaborator on a GitHub repository"

############################################ SETTINGS
# Collect positional args here; route help flags through the sake helper.
args=()
while (($#)); do
    case $1 in
    *)
        if sake_handle_help_flag "$1"; then
            shift
            continue
        fi
        args+=("$1")
        ;;
    esac
    shift
done
set -- "${args[@]}"

############################################ HELP

help_and_exit() {
    ECHOHEAD "Git add collaborator"
    echonice "Adds a collaborator to a GitHub repository"
    echonice ""
    echonice "directory of script:           $SCRIPT_DIR"

    ECHOHEAD "Available settings:"
    echonice "-h, --help                     show help information"
    echonice "owner/repo                     e.g. my-org/silverstripe-mymodule"
    echonice "username                       GitHub username to invite"
    ECHOHEAD "permission                     use one of:"
    echonice "                               push (default!)"
    echonice "                               pull"
    echonice "                               triage"
    echonice "                               maintain"
    echonice "                               admin"
    echonice "Token                          set GITHUB_TOKEN env var,"
    echonice "                               or place it in ~/.github_token"

    ECHOHEAD "Example usage:"
    echonice "e.g. sake-git-add-collaborator my-org/silverstripe-mymodule octocat"

    echofunctions
    exit
}

sake_check_help_and_exit

############################################ CODE

# --- Configuration ---------------------------------------------------------

API="https://api.github.com"

# --- Helpers ---------------------------------------------------------------

die() { printf 'Error: %s\n' "$*" >&2; exit 1; }

# --- Parse arguments -------------------------------------------------------

if [[ $# -lt 2 || $# -gt 3 ]]; then help_and_exit; fi

REPO="$1"
USERNAME="$2"
PERMISSION="${3:-push}"

# Validate owner/repo format
[[ "$REPO" == */* ]] || die "Repository must be in 'owner/repo' format (got: '$REPO')."

# Validate permission
case "$PERMISSION" in
    pull|triage|push|maintain|admin) ;;
    *) die "Invalid permission '$PERMISSION'. Use: pull, triage, push, maintain, or admin." ;;
esac

# --- Resolve token ---------------------------------------------------------
# Prefer the env var, fall back to ~/.github_token (matches the help text).

TOKEN="${GITHUB_TOKEN:-}"
if [[ -z "$TOKEN" && -r "$HOME/.github_token" ]]; then
    TOKEN="$(tr -d '[:space:]' < "$HOME/.github_token")"
fi
[[ -n "$TOKEN" ]] || die "No token found. Set GITHUB_TOKEN or create ~/.github_token."

command -v curl >/dev/null 2>&1 || die "curl is required but not installed."

# --- Make the request ------------------------------------------------------

echonice "Adding '$USERNAME' to '$REPO' with '$PERMISSION' permission..."

# Capture body and HTTP status separately.
response="$(
    curl -sS -w '\n%{http_code}' \
        -X PUT \
        -H "Accept: application/vnd.github+json" \
        -H "Authorization: Bearer $TOKEN" \
        -H "X-GitHub-Api-Version: 2022-11-28" \
        "$API/repos/$REPO/collaborators/$USERNAME" \
        -d "{\"permission\":\"$PERMISSION\"}"
)"

http_code="${response##*$'\n'}"
body="${response%$'\n'*}"

# --- Interpret result ------------------------------------------------------

case "$http_code" in
    201)
        echonice "Invitation sent. '$USERNAME' must accept it to become a collaborator."
        ;;
    204)
        echonice "Done. '$USERNAME' is already a collaborator; permission set to '$PERMISSION'."
        ;;
    403)
        die "Forbidden (403). Your token may lack admin rights on this repo. $body"
        ;;
    404)
        die "Not found (404). Check the repo name, the username, and that your token can see this repo. $body"
        ;;
    422)
        die "Unprocessable (422). The username may be invalid or already invited. $body"
        ;;
    *)
        die "Unexpected response (HTTP $http_code): $body"
        ;;
esac

echoend
