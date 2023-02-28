-- Add TODO tags to cmp source
local source = {}
local todos = {
  {
    label=" Error Reporting show USER",
    kind= 1,
    documention={
      kind = "variable",
      value ="Error Reporting show USER"
    }
  },
  {
    kind = 1,
    label="Error Reporting show ADMIN",
    documention={
     kind = "variable",
     value = " Error Error Reporting show ADMIN"
    }
  },
}

vim.cmd[[set tabstop=4]]
vim.cmd[[set shiftwidth=4]]

source.new = function()
  local self = setmetatable({ cache = {} }, { __index = source })

  return self
end

source.complete = function(self, _, callback)
   callback { items = todos, isIncomplete = false }
end

source.get_trigger_characters = function()
  return { ":" }
end

source.is_available = function()
  return true;
end

local cmp = require("cmp")
cmp.register_source("todo_tags", source.new())

local config = cmp.get_config()
table.insert(config.sources, {name="todo_tags", priority="100"})
